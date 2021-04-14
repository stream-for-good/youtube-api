<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\VideoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=VideoRepository::class)
 */
class Video
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity=Channel::class, inversedBy="videos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $channel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $language;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\Column(type="datetime")
     */
    private $publishedAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $addedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Capture::class, mappedBy="video", orphanRemoval=true)
     */
    private $captures;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="video", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=VideoCategoryLabel::class, mappedBy="video", orphanRemoval=true)
     */
    private $videoCategoryLabels;

    /**
     * @ORM\OneToMany(targetEntity=Stat::class, mappedBy="video", orphanRemoval=true)
     */
    private $stats;

    public function __construct()
    {
        $this->captures = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->videoCategoryLabels = new ArrayCollection();
        $this->stats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getChannel(): ?Channel
    {
        return $this->channel;
    }

    public function setChannel(?Channel $channel): self
    {
        $this->channel = $channel;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getAddedAt(): ?\DateTimeInterface
    {
        return $this->addedAt;
    }

    public function setAddedAt(\DateTimeInterface $addedAt): self
    {
        $this->addedAt = $addedAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|Capture[]
     */
    public function getCaptures(): Collection
    {
        return $this->captures;
    }

    public function addCapture(Capture $capture): self
    {
        if (!$this->captures->contains($capture)) {
            $this->captures[] = $capture;
            $capture->setVideo($this);
        }

        return $this;
    }

    public function removeCapture(Capture $capture): self
    {
        if ($this->captures->removeElement($capture)) {
            // set the owning side to null (unless already changed)
            if ($capture->getVideo() === $this) {
                $capture->setVideo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setVideo($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getVideo() === $this) {
                $comment->setVideo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|VideoCategoryLabel[]
     */
    public function getVideoCategoryLabels(): Collection
    {
        return $this->videoCategoryLabels;
    }

    public function addVideoCategoryLabel(VideoCategoryLabel $videoCategoryLabel): self
    {
        if (!$this->videoCategoryLabels->contains($videoCategoryLabel)) {
            $this->videoCategoryLabels[] = $videoCategoryLabel;
            $videoCategoryLabel->setVideo($this);
        }

        return $this;
    }

    public function removeVideoCategoryLabel(VideoCategoryLabel $videoCategoryLabel): self
    {
        if ($this->videoCategoryLabels->removeElement($videoCategoryLabel)) {
            // set the owning side to null (unless already changed)
            if ($videoCategoryLabel->getVideo() === $this) {
                $videoCategoryLabel->setVideo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Stat[]
     */
    public function getStats(): Collection
    {
        return $this->stats;
    }

    public function addStat(Stat $stat): self
    {
        if (!$this->stats->contains($stat)) {
            $this->stats[] = $stat;
            $stat->setVideo($this);
        }

        return $this;
    }

    public function removeStat(Stat $stat): self
    {
        if ($this->stats->removeElement($stat)) {
            // set the owning side to null (unless already changed)
            if ($stat->getVideo() === $this) {
                $stat->setVideo(null);
            }
        }

        return $this;
    }
}
