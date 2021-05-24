<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Dto\DataOutput;
use App\Entity\Log;
use App\Repository\LogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\RedisAdapter;

class OneLogOutputDataTransformer extends AbstractController implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    private $em;
    private $repoLog;
    private $const_prefix;
    private $const_redis_link;
    private $const_short_expiration;
    private $const_long_expiration;

    public function __construct(EntityManagerInterface $em, LogRepository $repoLog, $const_prefix, $const_redis_link, $const_short_expiration, $const_long_expiration)
    {
        $this->em = $em;
        $this->repoLog = $repoLog;
        $this->const_prefix = $const_prefix;
        $this->const_redis_link = $const_redis_link;
        $this->const_short_expiration = $const_short_expiration;
        $this->const_long_expiration = $const_long_expiration;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Log::class === $resourceClass;
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
        
        $idLog = $id;
        $msg = [];
        $captures = [];

        $data = $this->repoLog->find($idLog);

        $prefix = $this->const_prefix;

        $sessionLink = $prefix . "/api/session/". $data->getSession()->getId();
        $sessionLinkArray = [
            'rel' => 'session_id',
            'href' => $sessionLink
        ];

        if(!empty($data->getCurrentVideo()))
        {
        $videoLink = $prefix . "/api/video/". $data->getCurrentVideo()->getId();
        $videoLinkArray = [
            'rel' => 'current_video_id',
            'href' => $videoLink
        ];
        $links = array($sessionLinkArray, $videoLinkArray);
    }
        else
        {
            $links = array($sessionLinkArray);
        }

        foreach ($data->getCaptures() as $l) {
            $captureLink = $prefix . "/api/capture/" . $l->getId();
            $captureLinkArray = [
                        'rel' => 'capture_id',
                        'href' => $captureLink
                    ];

            $videoLink = $prefix . "/api/video/" . $l->getVideo()->getId();
            $videoLinkArray = [
                        'rel' => 'video_id',
                        'href' => $videoLink
                    ];  

            $sub_capture = array(
                'captureID'=>$l->getId(),
                'videoID'=>$l->getVideo()->getId(),
                'position'=>$l->getPosition(),
                'links'=>array($captureLinkArray,$videoLinkArray)
            );   
            array_push($captures, $sub_capture);
            
        }

        $capture = array($captures);
        
        $dataSend = [
            "logID"=>$data->getId(),
            "sessionID"=>$data->getSession()->getId(),
            'actionID'=>$data->getAction()->getId().' ('.$data->getAction()->getName().')'
        ];

        if(!empty($data->getCurrentVideo()))
        {
        $dataSend["currendVideo"] = $data->getCurrentVideo()->getId();
        }
        $dataSend["create"] = $data->getCreateAt();
        $dataSend["links"] = $links;
        $dataSend["captures"] = $capture;

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