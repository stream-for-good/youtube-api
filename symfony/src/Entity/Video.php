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
use App\Dto\VideosInput;

/**
 * @ApiResource(
 *      shortName="All Videos",
 *      collectionOperations={
 *          "post"={
 *          "input"=VideosInput::class,
 *          "output"=VideosInput::class,
 *          "path"="/video/create/info"
 *          },
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
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=VideoInfo::class, mappedBy="video", orphanRemoval=true)
     */
    private $videoInfos;

    /**
     * @ORM\OneToMany(targetEntity=Log::class, mappedBy="currentVideo")
     */
    private $logs;

    /**
     * @ORM\OneToMany(targetEntity=VideoLabel::class, mappedBy="video", orphanRemoval=true)
     */
    private $videoLabels;


    public function __construct()
    {
        $this->captures = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->videoInfos = new ArrayCollection();
        $this->logs = new ArrayCollection();
        $this->videoLabels = new ArrayCollection();
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
     * @return Collection|VideoInfo[]
     */
    public function getVideoInfos(): Collection
    {
        return $this->videoInfos;
    }

    public function addVideoInfo(VideoInfo $videoInfo): self
    {
        if (!$this->videoInfos->contains($videoInfo)) {
            $this->videoInfos[] = $videoInfo;
            $videoInfo->setVideo($this);
        }

        return $this;
    }

    public function removeVideoInfo(VideoInfo $videoInfo): self
    {
        if ($this->videoInfos->removeElement($videoInfo)) {
            // set the owning side to null (unless already changed)
            if ($videoInfo->getVideo() === $this) {
                $videoInfo->setVideo(null);
            }
        }

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

    /**
     * @return Collection|VideoLabel[]
     */
    public function getVideoLabels(): Collection
    {
        return $this->videoLabels;
    }

    public function addVideoLabel(VideoLabel $videoLabel): self
    {
        if (!$this->videoLabels->contains($videoLabel)) {
            $this->videoLabels[] = $videoLabel;
            $videoLabel->setVideo($this);
        }

        return $this;
    }

    public function removeVideoLabel(VideoLabel $videoLabel): self
    {
        if ($this->videoLabels->removeElement($videoLabel)) {
            // set the owning side to null (unless already changed)
            if ($videoLabel->getVideo() === $this) {
                $videoLabel->setVideo(null);
            }
        }

        return $this;
    }

}
