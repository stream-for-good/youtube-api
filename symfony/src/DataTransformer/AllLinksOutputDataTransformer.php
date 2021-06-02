<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Dto\LinksOutput;
use App\Entity\ApiLinks;
use Exception;
use Symfony\Component\Cache\Adapter\RedisAdapter;

final class AllLinksOutputDataTransformer implements CollectionDataProviderInterface,  RestrictedDataProviderInterface
{
    private $const_prefix;
    private $const_redis_link;
    private $const_short_expiration;
    private $const_long_expiration;

    public function __construct($const_prefix, $const_redis_link, $const_short_expiration, $const_long_expiration)
    {
        $this->const_prefix = $const_prefix;
        $this->const_redis_link = $const_redis_link;
        $this->const_short_expiration = $const_short_expiration;
        $this->const_long_expiration = $const_long_expiration;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return ApiLinks::class === $resourceClass;
    }
    public function getCollection(string $resourceClass, string $operationName = null): \Generator
    {
        $output = new LinksOutput();
        $skip = false;
        $redisLink = $this->const_redis_link;
        $expiration = $this->const_long_expiration;
        $cacheKey = 'AllLinks';
        
        try {
            $cache = RedisAdapter::createConnection($redisLink);
            $cache->exists($cacheKey);
        } catch (Exception $e) {
            $skip = true;
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
        $output->setLinks($msg);
        yield $output;
    }

    private function queryData(): array
    {
        $msg =[];
        $prefix = $this->const_prefix;

        $sessionLink = $prefix . "/api/sessions";
        $sessionLinkArray = [
            'rel' => 'all-sessions',
            'href' => $sessionLink
        ];
        array_push($msg, $sessionLinkArray);

        $logsLink = $prefix . "/api/logs";
        $logsLinkArray = [
            'rel' => 'all-logs',
            'href' => $logsLink
        ];
        array_push($msg, $logsLinkArray);

        $capturesLink = $prefix . "/api/captures";
        $capturesLinkArray = [
            'rel' => 'all-captures',
            'href' => $capturesLink
        ];
        array_push($msg, $capturesLinkArray);

        $videosLink = $prefix . "/api/videos";
        $videosLinkArray = [
            'rel' => 'all-videos',
            'href' => $videosLink
        ];
        array_push($msg, $videosLinkArray);

        $channelsLink = $prefix . "/api/channels";
        $channelsLinkArray = [
            'rel' => 'all-channels',
            'href' => $channelsLink
        ];
        array_push($msg, $channelsLinkArray);
        
        $commentsLink = $prefix . "/api/comments";
        $commentsLinkArray = [
            'rel' => 'all-comments',
            'href' => $commentsLink
        ];
        array_push($msg, $commentsLinkArray);
        
        $captionsLink = $prefix . "/api/captions";
        $captionssLinkArray = [
            'rel' => 'all-captions',
            'href' => $captionsLink
        ];
        array_push($msg, $captionssLinkArray);

        $videoslabelLink = $prefix . "/api/videos/label";
        $videoslabelLinkArray = [
            'rel' => 'all-videos-label',
            'href' => $videoslabelLink
        ];
        array_push($msg, $videoslabelLinkArray);

        $channelslabelLink = $prefix . "/api/channels/label";
        $channelslabelLinkArray = [
            'rel' => 'all-channels/label',
            'href' => $channelslabelLink
        ];
        array_push($msg, $channelslabelLinkArray);

        $actionsLink = $prefix . "/api/actions";
        $actionsLinkArray = [
            'rel' => 'all-actions',
            'href' => $actionsLink
        ];
        array_push($msg, $actionsLinkArray);


        return $msg;
    }
}