<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Dto\DataOutput;
use App\Entity\ChannelLabel;
use App\Repository\ChannelLabelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\RedisAdapter;

final class AllChannelsLabelOutputDataTransformer extends AbstractController implements CollectionDataProviderInterface,  RestrictedDataProviderInterface
{
    private $em;
    private $repoChannelLabel;
    private $const_prefix;
    private $const_redis_link;
    private $const_short_expiration;
    private $const_long_expiration;

    public function __construct(EntityManagerInterface $em, ChannelLabelRepository $repoChannelLabel, $const_prefix, $const_redis_link, $const_short_expiration, $const_long_expiration)
    {
        $this->em = $em;
        $this->repoChannelLabel = $repoChannelLabel;
        $this->const_prefix = $const_prefix;
        $this->const_redis_link = $const_redis_link;
        $this->const_short_expiration = $const_short_expiration;
        $this->const_long_expiration = $const_long_expiration;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return ChannelLabel::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null): \Generator
    {
        $output = new DataOutput();
        
        $skip = false;
        $redisLink = $this->const_redis_link;
        $expiration = $this->const_long_expiration;
        $cacheKey = 'AllChannelsLabel';
        
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
        $output->setData($msg);
        yield $output;
    }

    private function queryData(): array
    {

        $msg = [];
        $data = $this->repoChannelLabel->findAll();
            
        $prefix = $this->const_prefix;

        foreach ($data as $value) {

            $channelLabelLink = $prefix . "/api/channel/label/". $value->getId();
            $channelLabelLinkArray = [
                'rel' => 'channel_label_id',
                'href' => $channelLabelLink
            ];

            $channelLink = $prefix . "/api/channel/". $value->getChannel()->getId();
            $channelLinkArray = [
                'rel' => 'channel_id',
                'href' => $channelLink
            ];

            $links = array($channelLabelLinkArray, $channelLinkArray);

            $dataSend = [
                "id"=>$value->getId(),
                "channelID" => $value->getChannel()->getId(),
                "links"=>$links
            ];

            array_push($msg, $dataSend);
        }
        return $msg;
    }
}