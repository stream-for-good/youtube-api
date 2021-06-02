<?php

namespace App\Rabbit;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use App\Entity\Video;
use App\Entity\Channel;
use App\Entity\Label;
use App\Entity\ChannelLabel;
use App\Entity\Comment;
use App\Entity\Caption;
use App\Repository\LabelRepository;
use App\Repository\VideoRepository;
use App\Repository\ChannelRepository;
use App\Repository\CaptionRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use \DateTime;

class MessageConsumer implements ConsumerInterface
{

    private $em;
    private $repoChannel;
    private $repoVideo;
    private $repoLabel;
    private $repoCaption;
    private $repoComment;

    public function __construct(EntityManagerInterface $em, MessagingProducer $videoMetaData, MessagingProducer $videoComment, CaptionRepository $repoCaption, CommentRepository $repoComment, ChannelRepository $repoChannel, VideoRepository $repoVideo, LabelRepository $repoLabel)
    {
        $this->em = $em;
        $this->repoChannel = $repoChannel;
        $this->repoVideo = $repoVideo;
        $this->repoLabel = $repoLabel;
        $this->repoCaption = $repoCaption;
        $this->repoComment = $repoComment;
    }

    public function execute(AMQPMessage $msg)
    {
        $message = json_decode($msg->body, true);

        if ($message['status'] == "SUCCESS") {
            if ($message['result']['type'] == "video_metadata") {
                $checkVideo = $this->repoVideo->findOneBy(["id" => $message['result']['video_id'], "status" => false]);

                if ($checkVideo) {
                    if (!empty($message['result']['payload']['items'][0]['snippet']['channelId'])) {
                        $checkChannel = $this->repoChannel->findOneBy(["id" => $message['result']['payload']['items'][0]['snippet']['channelId']]);
                    } else {
                        $checkChannel = false;
                    }

                    $addLabel = $this->repoLabel->findOneBy(["id" => 1]);

                    if ($checkChannel) {
                        $checkVideo->setChannel($checkChannel);
                    }
                    if (!$checkChannel && !empty($message['result']['payload']['items'][0]['snippet']['channelId'])) {
                        $newChannel = new Channel();
                        $newChannel->setId($message['result']['payload']['items'][0]['snippet']['channelId']);
                        $newChannel->setName($message['result']['payload']['items'][0]['snippet']['channelTitle']);
                        $this->em->persist($newChannel);

                        $newChannelLabel = new ChannelLabel();
                        $newChannelLabel->setChannel($newChannel);
                        $newChannelLabel->setLabel($addLabel);

                        $this->em->persist($newChannelLabel);

                        $checkVideo->setChannel($newChannel);
                    }

                    if (!empty($message['result']['payload']['items'][0]['snippet']['title'])) {
                        $checkVideo->setTitle($message['result']['payload']['items'][0]['snippet']['title']);
                    }

                    if (empty($message['result']['payload']['items']['snippet'][0]['defaultAudioLanguage'])) {
                        $checkVideo->setLanguage("undefined");
                    } else {
                        $checkVideo->setLanguage($message['result']['payload']['items'][0]['snippet']['defaultAudioLanguage']);
                    }

                    if (!empty($message['result']['payload']['items'][0]['contentDetails']['duration'])) {
                        $checkVideo->setDuration($message['result']['payload']['items'][0]['contentDetails']['duration']);
                    }

                    if (!empty($message['result']['payload']['items'][0]['snippet']['publishedAt'])) {
                        $date = new DateTime($message['result']['payload']['items'][0]['snippet']['publishedAt']);
                        $checkVideo->setPublishedAt($date);
                    }

                    if (!empty($message['result']['payload']['items'][0]['statistics']['viewCount'])) {
                        $checkVideo->setViewCount($message['result']['payload']['items'][0]['statistics']['viewCount']);
                    }

                    if (!empty($message['result']['payload']['items'][0]['statistics']['likeCount'])) {
                        $checkVideo->setLikeCount($message['result']['payload']['items'][0]['statistics']['likeCount']);
                    }

                    if (!empty($message['result']['payload']['items'][0]['statistics']['dislikeCount'])) {
                        $checkVideo->setDislikeCount($message['result']['payload']['items'][0]['statistics']['dislikeCount']);
                    }

                    // $newVideoLabel = new VideoLabel();
                    // $newVideoLabel->setVideo($checkVideo);
                    // $newVideoLabel->setLabel($addLabel);
                    // $this->em->persist($newVideoLabel);

                    $checkVideo->setUpdatedAt(new DateTime());
                    $checkVideo->setStatus(true);
                    $this->em->persist($checkVideo);
                }
            }

            if ($message['result']['type'] == "comment") {
                $checkVideo = $this->repoVideo->findOneBy(["id" => $message['result']['video_id']]);
                $checkVideoIsPresent = $this->repoComment->findOneBy(["video" => $message['result']['video_id']]);

                if (!$checkVideoIsPresent && $checkVideo) {
                    foreach ($message['result']['payload'] as $comments) {
                        $newComment = new Comment();
                        $newComment->setVideo($checkVideo);
                        if (!empty($comments[2])) {
                            $newComment->setAuthor($comments[2]);
                        }
                        if (!empty($comments[0])) {
                            $newComment->setText($comments[0]);
                        }
                        if (!empty($comments[3])) {
                            $date = new DateTime($comments[3]);
                            $newComment->setPublishedAt($date);
                        }
                        $this->em->persist($newComment);
                    }
                }
            }

            if ($message['result']['type'] == "captions") {
                $checkVideo = $this->repoVideo->findOneBy(["id" => $message['result']['video_id']]);
                $checkVideoIsPresent = $this->repoCaption->findOneBy(["video" => $message['result']['video_id']]);

                if (!$checkVideoIsPresent && $checkVideo) {
                    $newCaption = new Caption();
                    $newCaption->setVideo($checkVideo);
                    if (!empty($message['result']['payload'])) {
                        $replaceFirst = str_replace('b"\n', ' ', $message['result']['payload']);
                        $replaceLast = str_replace('\n', ' ', $replaceFirst);
                        $newCaption->setText($replaceLast);
                    }

                    $this->em->persist($newCaption);
                }
            }

            $this->em->flush();

            echo $message['result']['video_id'] . "----" . $message['result']['type'] . "\n";
        }
    }
}
