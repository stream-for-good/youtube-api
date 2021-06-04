<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Dto\DataOutput;
use App\Entity\Session;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\RedisAdapter;

class OneSessionOutputDataTransformer extends AbstractController implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    private $em;
    private $repoSession;
    private $const_prefix;
    private $const_redis_link;
    private $const_short_expiration;
    private $const_long_expiration;

    public function __construct(EntityManagerInterface $em, SessionRepository $repoSession, $const_prefix, $const_redis_link, $const_short_expiration, $const_long_expiration)
    {
        $this->em = $em;
        $this->repoSession = $repoSession;
        $this->const_prefix = $const_prefix;
        $this->const_redis_link = $const_redis_link;
        $this->const_short_expiration = $const_short_expiration;
        $this->const_long_expiration = $const_long_expiration;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Session::class === $resourceClass;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?DataOutput
    {
        $output = new DataOutput();
        $skip = false;
        $redisLink = $this->const_redis_link;
        $expiration = $this->const_long_expiration;
        $cacheKey = 'OneSession_'.$id;
        
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
        
        $idSession = $id;
        $msg = [];
        $logs = [];

        $data = $this->repoSession->find($idSession);

        $prefix = $this->const_prefix;
        

        foreach ($data->getLogs() as $l) {
            $logLink = $prefix . "/api/log/" . $l->getId();
            $logLinkArray = [
                        'rel' => 'log_id',
                        'href' => $logLink
                    ];

        $actionLink = $prefix . "/api/action/" . $l->getAction()->getId();
        $actionLinkArray = [
            'name' => $l->getAction()->getName(),
            'rel' => 'action_id',
            'href' => $actionLink
        ];

        $links = array($logLinkArray, $actionLinkArray);

            if(!empty($l->getCurrentVideo()))
            {
            $sub_log = array(
                'logID'=>$l->getId(),
                'actionID'=>$l->getAction()->getId(),
                'currentVideo'=>$l->getCurrentVideo()->getId(),
                'links'=>$links
            );
        }
        else{
            $sub_log = array(
                'logID'=>$l->getId(),
                'actionID'=>$l->getAction()->getId(),
                'links'=>$links
            );   
        }
            array_push($logs, $sub_log);
            
        }

        $log = array($logs);
        
        $dataSend = [
            "id"=>$data->getId(),
            "create"=>$data->getCreateAt()->format('Y-m-d H:i:s'),
            "logs" => $log
        ];

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