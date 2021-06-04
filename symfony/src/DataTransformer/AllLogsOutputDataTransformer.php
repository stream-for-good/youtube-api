<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Dto\DataOutput;
use App\Entity\Log;
use App\Repository\LogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\RedisAdapter;


final class AllLogsOutputDataTransformer extends AbstractController implements CollectionDataProviderInterface,  RestrictedDataProviderInterface
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

    public function getCollection(string $resourceClass, string $operationName = null): \Generator
    {
        $output = new DataOutput();
        
        $skip = false;
        $redisLink = $this->const_redis_link;
        $expiration = $this->const_long_expiration;
        $cacheKey = 'AllLogs';
        
        try {
            $cache = RedisAdapter::createConnection($redisLink);
            $cache->exists($cacheKey);
        } catch (Exception $e) {
            $skip = true;
            dump("error");
        }
        if($skip){
            $msg = $this->queryData();
        }
        else{
            if(!$cache->exists($cacheKey)){
                $msg = $this->queryData();
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
        yield $output;
    }

    private function queryData(): array
    {

        $msg = [];
        $data = $this->repoLog->findBy([], ['id' => 'DESC']);
            
        $prefix = $this->const_prefix;

        foreach ($data as $value) {

            $logLink = $prefix . "/api/log/". $value->getId();
            $logLinkArray = [
                'rel' => 'log_id',
                'href' => $logLink
            ];
            
            $sessionLink = $prefix . "/api/session/". $value->getSession()->getId();
            $sessionLinkArray = [
                'rel' => 'session_id',
                'href' => $sessionLink
            ];

            $actionLink = $prefix . "/api/action/" . $value->getAction()->getId();
            $actionLinkArray = [
                'name' => $value->getAction()->getName(),
                'rel' => 'action_id',
                'href' => $actionLink
            ];

            $links = array($logLinkArray, $sessionLinkArray, $actionLinkArray);
            if($value->getCurrentVideo() != null)
            {
            $dataSend = [
                "id"=>$value->getId(),
                "sessionID"=>$value->getSession()->getId(),
                'actionID'=>$value->getAction()->getId(),
                "current_video"=>$value->getCurrentVideo()->getId(),
                "links"=>$links
            ];
            }
            else{
                $dataSend = [
                    "id"=>$value->getId(),
                    "sessionID"=>$value->getSession()->getId(),
                    'actionID'=>$value->getAction()->getId(),
                    "links"=>$links
                ];     
            }

            array_push($msg, $dataSend);
        }
        return $msg;
    }
}