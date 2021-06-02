<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Dto\DataOutput;
use App\Entity\Capture;
use App\Repository\CaptureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\RedisAdapter;

class OneCaptureOutputDataTransformer extends AbstractController implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    private $em;
    private $repoCapture;
    private $const_prefix;
    private $const_redis_link;
    private $const_short_expiration;
    private $const_long_expiration;

    public function __construct(EntityManagerInterface $em, CaptureRepository $repoCapture, $const_prefix, $const_redis_link, $const_short_expiration, $const_long_expiration)
    {
        $this->em = $em;
        $this->repoCapture = $repoCapture;
        $this->const_prefix = $const_prefix;
        $this->const_redis_link = $const_redis_link;
        $this->const_short_expiration = $const_short_expiration;
        $this->const_long_expiration = $const_long_expiration;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Capture::class === $resourceClass;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?DataOutput
    {
        $output = new DataOutput();
        $skip = false;
        $redisLink = $this->const_redis_link;
        $expiration = $this->const_long_expiration;
        $cacheKey = 'OneLog_'.$id;
        
        try {
            $cache = RedisAdapter::createConnection($redisLink);
            $cache->exists($cacheKey);
        } catch (Exception $e) {
            $skip = true;
        }
        if($skip){
            $msg = $this->queryData($id);
        }
        else{
            if(!$cache->exists($cacheKey)){
                $msg = $this->queryData($id);
                if(!empty($msg) && !array_key_exists('err',$msg)){
                    $redisMsg = json_encode($msg);
                    $cache->set($cacheKey, $redisMsg);
                    $cache->expire($cacheKey, $expiration);
                }
            }
            else{
                $msg = json_decode($cache->get($cacheKey), true);
            }
        }

        $output->setData($msg);
        return $output;
    }

    private function queryData($id): array
    {
        
        $idCapture = $id;
        $msg = [];
        $stats = [];

        $data = $this->repoCapture->find($idCapture);

        $prefix = $this->const_prefix;

        $logLink = $prefix . "/api/log/". $data->getLog()->getId();
        $logLinkArray = [
            'rel' => 'log_id',
            'href' => $logLink
        ];

        $videoLink = $prefix . "/api/video/". $data->getVideo()->getId();
        $videoLinkArray = [
            'rel' => 'video_id',
            'href' => $videoLink
        ];

        $links = array($logLinkArray, $videoLinkArray);
        
        $dataSend = [
            "captureID"=>$data->getId(),
            "logID"=>$data->getLog()->getId(),
            "videoID"=>$data->getVideo()->getId(),
            "position"=>$data->getPosition()
        ];
        $dataSend["links"] = $links;

        array_push($msg, $dataSend);

        return $msg;
    }

    /**
     * @inheritDoc
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return DataOutput::class === $to ;
    }
}