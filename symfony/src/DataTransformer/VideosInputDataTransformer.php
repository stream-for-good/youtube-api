<?php
// src/DataTransformer/BookInputDataTransformer.php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Video;
use App\Entity\VideoLabel;
use App\Entity\Channel;
use App\Entity\ChannelLabel;
use App\Entity\Label;

final class VideosInputDataTransformer extends AbstractController  implements DataTransformerInterface
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

    /**
     * {@inheritdoc}
     */
    public function transform($data, string $to, array $context = [])
    {
        $em = $this->getDoctrine()->getManager();
        $addLabel = $this->getDoctrine()
        ->getRepository(Label::class)
        ->findOneBy(["id"=>1]);

            $items_data = $data->getitems();

        $itemsPerQuery = 80;
        // $itemsPerQuery = count($items_data);

        foreach($items_data as $key=>$item){

        $checkVideo = $this->getDoctrine()
        ->getRepository(Video::class)
        ->findOneBy(["id"=>$item["videoId"]]);

        $checkChannel = $this->getDoctrine()
        ->getRepository(Channel::class)
        ->findOneBy(["id"=>$item["channelId"]]);

        if($checkVideo)
        {

            if($checkChannel)
            {
                $newChannelLabel = new ChannelLabel();
                $newChannelLabel->setChannel($checkChannel);
                $newChannelLabel->setLabel($addLabel);
                $em->persist($newChannelLabel);

                
            }
            else
            {
                $newChannel = new Channel();
                $newChannel->setId($item["channelId"]);
                $newChannel->setName($item["channelName"]);
                $em->persist($newChannel);

                $newChannelLabel = new ChannelLabel();
                $newChannelLabel->setChannel($newChannel);
                $newChannelLabel->setLabel($addLabel);

                $em->persist($newChannelLabel);

            }



            $newVideoLabel = new VideoLabel();
            $newVideoLabel->setVideo($checkVideo);
            $newVideoLabel->setLabel($addLabel);
            $em->persist($newVideoLabel);

            $checkVideo->setStatus(true);
            $em->persist($checkVideo);
        }

        }

        return $checkVideo;
 
    }

    /**
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof Video) {
          return false;
        }

        return Video::class === $to && null !== ($context['input']['class'] ?? null);
    }
}