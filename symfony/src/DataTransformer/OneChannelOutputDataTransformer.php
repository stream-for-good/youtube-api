<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Dto\DataOutput;
use App\Entity\Channel;
use App\Repository\ChannelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\RedisAdapter;

class OneChannelOutputDataTransformer extends AbstractController implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    private $em;
    private $repoChannel;
    private $const_prefix;
    private $const_redis_link;
    private $const_short_expiration;
    private $const_long_expiration;

    public function __construct(EntityManagerInterface $em, ChannelRepository $repoChannel, $const_prefix, $const_redis_link, $const_short_expiration, $const_long_expiration)
    {
        $this->em = $em;
        $this->repoChannel = $repoChannel;
        $this->const_prefix = $const_prefix;
        $this->const_redis_link = $const_redis_link;
        $this->const_short_expiration = $const_short_expiration;
        $this->const_long_expiration = $const_long_expiration;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Channel::class === $resourceClass;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?DataOutput
    {
        $output = new DataOutput();
        $skip = false;
        $redisLink = $this->const_redis_link;
        $expiration = $this->const_long_expiration;
        $cacheKey = 'OneChannel_'.$id;
        
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
        
        $idChannel = $id;
        $msg = [];
        $videos = [];

        $data = $this->repoChannel->find($idChannel);

        $prefix = $this->const_prefix;

        $channelLabelLink = $prefix . "/api/channel/label/". $data->getChannelLabel()->getId();
        $channelLabelLinkArray = [
            'rel' => 'channel_label_id',
            'href' => $channelLabelLink
        ];

        $links = array($channelLabelLinkArray);


        foreach ($data->getVideos() as $l) {
            $videoLink = $prefix . "/api/video/" . $l->getId();
            $videoLinkArray = [
                        'rel' => 'video_id',
                        'href' => $videoLink
                    ];

            $sub_video = array(
                'videoID'=>$l->getId(),
                'links'=>array($videoLinkArray)
            );   
            array_push($videos, $sub_video);
            
        }

        $video = array($videos);
        
        $dataSend = [
            "channelID"=>$data->getId()
        ];
        $dataSend["links"] = $links;
        $dataSend["videos"] = $video;

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