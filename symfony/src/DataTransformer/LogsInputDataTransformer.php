<?php
// src/DataTransformer/BookInputDataTransformer.php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Log;
use App\Entity\Session;
use App\Entity\Action;
use App\Entity\Video;
use App\Entity\Capture;
final class LogsInputDataTransformer extends AbstractController  implements DataTransformerInterface
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
                
        $checkVideo = $this->getDoctrine()
        ->getRepository(Video::class)
        ->findAll();
        
        $video_array = array();
        foreach ($checkVideo as $videoid){
            array_push($video_array, $videoid->getId());
        }

        $checkSession = $this->getDoctrine()
        ->getRepository(Session::class)
        ->find($data->session);
        $checkAction = $this->getDoctrine()
        ->getRepository(Action::class)
        ->find($data->action);

        $newLog = new Log();
        $newLog->setSession($checkSession);
        $newLog->setAction($checkAction);
        if (($data->currentVideo != null) && (in_array($data->currentVideo, $video_array))) {
            $searchCurrentVideo = $this->getDoctrine()
            ->getRepository(Video::class)
            ->find($data->currentVideo);
            $newLog->setCurrentVideo($searchCurrentVideo);
        }
        elseif(!empty($data->currentVideo))
        {
            $searchVideoCurrent = $this->getDoctrine()
            ->getRepository(Video::class)
            ->find($data->currentVideo);
            if(!$searchVideoCurrent)
            {
            $newVideo = new Video();
            $newVideo->setId($data->currentVideo);
            $newVideo->setStatus(false);
            $em->persist($newVideo);
            $newLog->setCurrentVideo($newVideo);
            }
            else
            {
                $newLog->setCurrentVideo($searchVideoCurrent);     
            }
        }
        if($data->action == 2 || $data->action == 3)
        {
        foreach ($data->videos as $key=>$v) {
            if (in_array($v, $video_array)) {
                $searchVideo = $this->getDoctrine()
                ->getRepository(Video::class)
                ->find($v);
                $capture = new Capture();
                $capture->setPosition($key);
                $capture->setLog($newLog);
                $capture->setVideo($searchVideo);
                $em->persist($capture);
            }
            else
            {
            $video = new Video();
            $video->setId($v);
            $video->setStatus(false);
            $capture = new Capture();
            $capture->setPosition($key);
            $capture->setLog($newLog);
            $em->persist($capture);
            $video->addCapture($capture);
            $em->persist($video);
            }
        }
        }

        return $newLog;
 
    }

    /**
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof Log) {
          return false;
        }

        return Log::class === $to && null !== ($context['input']['class'] ?? null);
    }
}