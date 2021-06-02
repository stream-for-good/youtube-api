<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Dto\DataOutput;
use App\Entity\Video;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use \DateTime;
use \DateInterval;

class OneVideoOutputDataTransformer extends AbstractController implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    private $em;
    private $repoVideo;
    private $const_prefix;
    private $const_redis_link;
    private $const_short_expiration;
    private $const_long_expiration;

    public function __construct(EntityManagerInterface $em, VideoRepository $repoVideo, $const_prefix, $const_redis_link, $const_short_expiration, $const_long_expiration)
    {
        $this->em = $em;
        $this->repoVideo = $repoVideo;
        $this->const_prefix = $const_prefix;
        $this->const_redis_link = $const_redis_link;
        $this->const_short_expiration = $const_short_expiration;
        $this->const_long_expiration = $const_long_expiration;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Video::class === $resourceClass;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?DataOutput
    {
        $output = new DataOutput();
        $skip = false;
        $redisLink = $this->const_redis_link;
        $expiration = $this->const_long_expiration;
        $cacheKey = 'OneVideo_'.$id;
        
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

        $idvideo = $id;
        $msg = [];
        $comments = [];

        $data = $this->repoVideo->find($idvideo);

        $channelID = is_null($data->getChannel()) ? null : $data->getChannel()->getId();

        if(!is_null($data->getTitle()))
        {
        $prefix = $this->const_prefix;

        $captionLinkArray = [
            'rel' => 'caption_id'
        ];

        if(is_null($data->getCaption()))
        {
            $captionMessage = "No caption for this video";
            $captionLinkArray["message"] = $captionMessage;
        }
        else
        {
            $captionLink = $prefix . "/api/caption/". $data->getCaption()->getId();
            $captionLinkArray["href"] = $captionLink;
        }

        if(!is_null($channelID))
        {
            $channelLink = $prefix . "/api/channel/". $data->getChannel()->getId();
            $channelLinkArray = [
                'rel' => 'channel_id',
                'href' => $channelLink
            ];
        }

        $videoLink = $prefix . "/api/video/label/". $data->getVideoLabel()->getId();
        $videoLinkArray = [
            'rel' => 'video_label',
            'href' => $videoLink
        ];
        $links = is_null($channelID) ? array($videoLinkArray, $captionLinkArray) : array($channelLinkArray, $videoLinkArray, $captionLinkArray);


        foreach ($data->getComments() as $l) {
            $commentLink = $prefix . "/api/comment/" . $l->getId();
            $commentLinkArray = [
                        'rel' => 'comment_id',
                        'href' => $commentLink
                    ];

            $sub_comment = array(
                'commentID'=>$l->getId(),
                'links'=>array($commentLinkArray)
            );   
            array_push($comments, $sub_comment);
            
        }

        $comment = array($comments);

        if(!is_null($data->getDuration()))
        {
        $dateIntervalDuration = new DateInterval($data->getDuration());
        $transformDuration = str_replace("00:", "", $dateIntervalDuration->format('%H:%i:%s'));
        }
        else
        {
            $transformDuration = null;
        }

        $dataSend = [
            "videoID"=>$data->getId(),
            "channelID"=>$channelID,
            "title"=>$data->getTitle(),
            "language"=>$data->getLanguage(),
            "duration"=> $transformDuration,
            "publishedAt"=>$data->getPublishedAt()->format('Y-m-d H:i:s'),
            "view"=>$data->getViewCount(),
            "like"=>$data->getLikeCount(),
            "dislike"=>$data->getDislikeCount()
        ];
        if(!is_null($data->getUpdatedAt()))
        {
            $dataSend["last update"] = $data->getUpdatedAt()->format('Y-m-d H:i:s');
        }
        $dataSend["links"] = $links;
        $dataSend["comments"] = $comment;

        array_push($msg, $dataSend);

    }
    else
    {
        $dataSend = [
            "videoID"=>$data->getId(),
            "message"=> "Video deleted or not updated"
        ];
        array_push($msg, $dataSend);
    }

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