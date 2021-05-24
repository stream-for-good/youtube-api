<?php

namespace App\Dto;

use Doctrine\ORM\Mapping as ORM;

final class LogsOutput {
    /**
     * @ORM\Column(type="string", length=255)
     */
    public $session;

    /**
     * @ORM\Column(type="integer")
     */
    public $action;

    /**
     * @ORM\Column(type="string", length=255)
    */
    public $currentVideo;

    /**
     * @ORM\Column(type="array")
     */
    public $videos;

    /**
     * @ORM\Column(type="integer")
     */
    public $viewCount;

    /**
     * @ORM\Column(type="integer")
     */
    public $likeCount;

    /**
     * @ORM\Column(type="integer")
     */
    public $dislikeCount;

    public function getSession(): ?string
    {
        return $this->session;
    }

    public function setSession(string $session): self
    {
        $this->session = $session;

        return $this;
    }

    public function getCurrentVideo(): ?string
    {
        return $this->currentVideo;
    }

    public function setCurrentVideo(string $currentVideo): self
    {
        $this->currentVideo = $currentVideo;

        return $this;
    }

    public function getAction(): ?int
    {
        return $this->action;
    }
    public function setAction(int $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getViewCount(): ?int
    {
        return $this->viewCount;
    }
    public function setViewCount(int $viewCount): self
    {
        $this->viewCount = $viewCount;

        return $this;
    }

    public function getLikeCount(): ?int
    {
        return $this->likeCount;
    }
    public function setLikeCount(int $likeCount): self
    {
        $this->likeCount = $likeCount;

        return $this;
    }

    public function getDislikeCount(): ?int
    {
        return $this->dislikeCount;
    }
    public function setDislikeCount(int $dislikeCount): self
    {
        $this->dislikeCount = $dislikeCount;

        return $this;
    }

    public function getVideos(): ?array
    {
        return $this->videos;
    }
    public function setVideos(array $videos): self
    {
        $this->videos = $videos;

        return $this;
    }
}