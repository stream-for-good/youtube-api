<?php

namespace App\Service;

use App\Rabbit\MessagingProducer;
use Faker\Factory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Uid\Uuid;
use App\Entity\Video;
use App\Entity\VideoLabel;
use App\Entity\Label;
use App\Repository\VideoRepository;
use App\Repository\LabelRepository;
use Doctrine\ORM\EntityManagerInterface;

class MessageService
{
    private $em;
    private $videoMetaData;
    private $videoComment;
    private $videoCaptions;
    private $repoLabel;
    private $repoVideo;

    public function __construct(EntityManagerInterface $em, LabelRepository $repoLabel, VideoRepository $repoVideo, MessagingProducer $videoMetaData, MessagingProducer $videoComment, MessagingProducer $videoCaptions)
    {
        $this->videoMetaData = $videoMetaData;
        $this->videoComment = $videoComment;
        $this->videoCaptions = $videoCaptions;
        $this->repoLabel = $repoLabel;
        $this->repoVideo = $repoVideo;
        $this->em = $em;
    }

    public function createMessage(string $videoYB): JsonResponse
    {

        // $takenLabel = $this->repoLabel->find(1);
        // $checkVideo = $this->repoVideo->find($videoYB);

        $message = '[["' . $videoYB . '"], {}, {"callbacks": null, "errbacks": null, "chain": null, "chord": null}]';

        // if (is_null($checkVideo)) {
        //     $newVideo = new Video();
        //     $newVideo->setId($videoYB);
        //     $newVideo->setStatus(false);
        //     $this->em->persist($newVideo);

        //     $newVideoLabel = new VideoLabel();
        //     $newVideoLabel->setLabel($takenLabel);
        //     $newVideoLabel->setVideo($newVideo);
        //     $this->em->persist($newVideoLabel);

        //     $this->em->flush();
        // }


        $this->videoMetaData->setId(Uuid::v4());
        $this->videoMetaData->setContentType('application/json');
        $this->videoMetaData->setResponseQueue('youtube-response');
        $this->videoMetaData->setTask('youtube.scrap_video_metadata');
        $this->videoMetaData->publish($message);

        $this->videoComment->setId(Uuid::v4());
        $this->videoComment->setContentType('application/json');
        $this->videoComment->setResponseQueue('youtube-response');
        $this->videoComment->setTask('youtube.scrap_comment');
        $this->videoComment->publish($message);

        $this->videoCaptions->setId(Uuid::v4());
        $this->videoCaptions->setContentType('application/json');
        $this->videoCaptions->setResponseQueue('youtube-response');
        $this->videoCaptions->setTask('youtube.scrap_captions');
        $this->videoCaptions->publish($message);

        return new JsonResponse(['status' => 'Sent!']);
    }
}
