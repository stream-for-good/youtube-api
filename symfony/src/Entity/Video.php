<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\VideoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Dto\DataOutput;

/**
 * @ApiResource(
 *      shortName="All Videos",
 *      collectionOperations={
 *          "get"={
 *              "output"=DataOutput::class,
 *              "path"="/videos",
 *              "formats"={"json"}
 *          }
 *      },
 *      itemOperations={
 *          "get"={
 *              "output"=DataOutput::class,
 *              "path"="/video/{id}",
 *              "formats"={"json"}
 *           }
 *      }
 * )
 * @ORM\Entity(repositoryClass=VideoRepository::class)
 * @UniqueEntity("id")
 */
class Video
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255, unique=true)
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Log::class, mappedBy="currentVideo")
     */
    private $logs;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="currentVideo", mappedBy="video", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=Capture::class, mappedBy="currentVideo", mappedBy="video", orphanRemoval=true)
     */
    private $captures;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity=Channel::class, inversedBy="videos")
     */
    private $channel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $language;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $duration;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $viewCount;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $likeCount;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $dislikeCount;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $publishedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $addedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\OneToOne(targetEntity=VideoLabel::class, mappedBy="video", cascade={"persist", "remove"})
     */
    private $videoLabel;

    /**
     * @ORM\OneToOne(targetEntity=Caption::class, mappedBy="video", cascade={"persist", "remove"})
     */
    private $caption;

    public function __construct()
    {
        $this->addedAt=new \DateTime();
        $this->captures = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->logs = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }
    public function setId(string $id): self
    {
        $this->id = $id;

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

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|Log[]
     */
    public function getLogs(): Collection
    {
        return $this->logs;
    }

    public function addLog(Log $log): self
    {
        if (!$this->logs->contains($log)) {
            $this->logs[] = $log;
            $log->setCurrentVideo($this);
        }

        return $this;
    }

    public function removeLog(Log $log): self
    {
        if ($this->logs->removeElement($log)) {
            // set the owning side to null (unless already changed)
            if ($log->getCurrentVideo() === $this) {
                $log->setCurrentVideo(null);
            }
        }

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
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

    public function setLanguage(?string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(?string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getViewCount(): ?int
    {
        return $this->viewCount;
    }

    public function setViewCount(?int $viewCount): self
    {
        $this->viewCount = $viewCount;

        return $this;
    }

    public function getLikeCount(): ?int
    {
        return $this->likeCount;
    }

    public function setLikeCount(?int $likeCount): self
    {
        $this->likeCount = $likeCount;

        return $this;
    }

    public function getDislikeCount(): ?int
    {
        return $this->dislikeCount;
    }

    public function setDislikeCount(?int $dislikeCount): self
    {
        $this->dislikeCount = $dislikeCount;

        return $this;
    }

    public function getPublishedAt(): ?\DateTime
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTime $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getAddedAt(): ?\DateTime
    {
        return $this->addedAt;
    }

    public function setAddedAt(?\DateTime $addedAt): self
    {
        $this->addedAt = $addedAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getVideoLabel(): ?VideoLabel
    {
        return $this->videoLabel;
    }

    public function setVideoLabel(VideoLabel $videoLabel): self
    {
        // set the owning side of the relation if necessary
        if ($videoLabel->getVideo() !== $this) {
            $videoLabel->setVideo($this);
        }

        $this->videoLabel = $videoLabel;

        return $this;
    }

    public function getCaption(): ?Caption
    {
        return $this->caption;
    }

    public function setCaption(Caption $caption): self
    {
        // set the owning side of the relation if necessary
        if ($caption->getVideo() !== $this) {
            $caption->setVideo($this);
        }

        $this->caption = $caption;

        return $this;
    }

}
