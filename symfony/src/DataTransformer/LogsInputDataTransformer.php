<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Log;
use App\Entity\Session;
use App\Entity\Action;
use App\Entity\Video;
use App\Entity\VideoLabel;
use App\Entity\Label;
use App\Entity\Capture;
use App\Service\MessageService;


final class LogsInputDataTransformer extends AbstractController  implements DataTransformerInterface
{
    private $const_prefix;
    private $const_redis_link;
    private $const_short_expiration;
    private $const_long_expiration;
    private $messageService;

    public function __construct(MessageService $messageService, $const_prefix, $const_redis_link, $const_short_expiration, $const_long_expiration)
    {
        $this->const_prefix = $const_prefix;
        $this->const_redis_link = $const_redis_link;
        $this->const_short_expiration = $const_short_expiration;
        $this->const_long_expiration = $const_long_expiration;
        $this->messageService = $messageService;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($data, string $to, array $context = [])
    {
        $em = $this->getDoctrine()->getManager();

        $videosArray = [];
        $currentVideo = $data->currentVideo;

        $takenLabel = $this->getDoctrine()
            ->getRepository(Label::class)
            ->find(1);

        if (!is_null($data->videos)) {
            $videosArray = $data->videos;
        }
        if (!is_null($currentVideo)) {
            array_push($videosArray, $currentVideo);
        }

        $videos = $this->getDoctrine()
            ->getRepository(Video::class)
            ->findByAllVideosInArray($videosArray);

        $videosId = array_map(function ($value) {
            return $value->getId();
        }, $videos);

        $checkSession = $this->getDoctrine()
            ->getRepository(Session::class)
            ->find($data->session);

        $checkAction = $this->getDoctrine()
            ->getRepository(Action::class)
            ->find($data->action);

        $newLog = new Log();
        $newLog->setSession($checkSession);
        $newLog->setAction($checkAction);

        if (!empty($currentVideo)) {

            $searchVideoCurrent = in_array($currentVideo, $videosId);

            if (!$searchVideoCurrent) {

                $newVideo = new Video();
                $newVideo->setId($currentVideo);
                $newVideo->setStatus(false);
                $em->persist($newVideo);

                $newVideoLabel = new VideoLabel();
                $newVideoLabel->setLabel($takenLabel);
                $newVideoLabel->setVideo($newVideo);
                $em->persist($newVideoLabel);

                $newLog->setCurrentVideo($newVideo);
                $this->messageService->createMessage($currentVideo);

                array_push($videos, $newVideo);
                array_push($videosId, $newVideo->getId());
            } else {
                foreach ($videos as $value) {
                    if ($value->getId() == $currentVideo) {
                        $currentVideoObj = $value;
                        break;
                    }
                }
                $newLog->setCurrentVideo($currentVideoObj);
            }
        }
        if (!empty($data->key_word)) {
            $newLog->setWords($data->key_word);
        }
        
        if (!empty($data->index)) {
            $newLog->setActionNumber($data->index);
        }
        if (!empty($data->position)) {
            $newLog->setIndexVideo($data->position);
        }
        if ($data->action == 2 || $data->action == 3 || $data->action == 6 || $data->action == 7) {
            if (!is_null($data->videos) && count($data->videos) > 0) {

                foreach ($data->videos as $key => $v) {

                    $searchVideo = false;

                    foreach ($videosId as $keyVideoId => $videoId) {
                        if ($v == $videoId) {
                            $searchVideo = true;
                            $indexVideoId = $keyVideoId;
                            break;
                        }
                    }

                    if ($searchVideo) {
                        $capture = new Capture();
                        $capture->setPosition($key);
                        $capture->setLog($newLog);
                        $capture->setVideo($videos[$indexVideoId]);
                        $em->persist($capture);
                    } else {
                        $video = new Video();
                        $video->setId($v);
                        $video->setStatus(false);
                        $this->messageService->createMessage($v);

                        $newVideoLabel = new VideoLabel();
                        $newVideoLabel->setLabel($takenLabel);
                        $newVideoLabel->setVideo($video);
                        $em->persist($newVideoLabel);

                        $capture = new Capture();
                        $capture->setPosition($key);
                        $capture->setLog($newLog);

                        $video->addCapture($capture);

                        $em->persist($capture);
                        $em->persist($video);

                        array_push($videos, $video);
                        array_push($videosId, $video->getId());
                    }
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
