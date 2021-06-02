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
     * @ORM\Column(type="string", length=255)
     */
    public $key_word;
    
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

    public function getKey_word(): ?string
    {
        return $this->key_word;
    }

    public function setKey_word(string $key_word): self
    {
        $this->key_word = $key_word;

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