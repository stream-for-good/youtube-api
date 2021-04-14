<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\StatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=StatRepository::class)
 */
class Stat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Video::class, inversedBy="stats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $video;

    /**
     * @ORM\ManyToOne(targetEntity=Capture::class, inversedBy="stats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $capture;

    /**
     * @ORM\Column(type="integer")
     */
    private $viewCount;

    /**
     * @ORM\Column(type="integer")
     */
    private $likeCount;

    /**
     * @ORM\Column(type="integer")
     */
    private $dislikeCount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVideo(): ?Video
    {
        return $this->video;
    }

    public function setVideo(?Video $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getCapture(): ?Capture
    {
        return $this->capture;
    }

    public function setCapture(?Capture $capture): self
    {
        $this->capture = $capture;

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
}
