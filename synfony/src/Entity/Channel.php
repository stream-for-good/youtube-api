<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ChannelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ChannelRepository::class)
 */
class Channel
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Video::class, mappedBy="channel", orphanRemoval=true)
     */
    private $videos;

    /**
     * @ORM\OneToMany(targetEntity=ChannelCategoryLabel::class, mappedBy="channel", orphanRemoval=true)
     */
    private $channelCategoryLabels;

    public function __construct()
    {
        $this->videos = new ArrayCollection();
        $this->channelCategoryLabels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Video[]
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->setChannel($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->videos->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getChannel() === $this) {
                $video->setChannel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ChannelCategoryLabel[]
     */
    public function getChannelCategoryLabels(): Collection
    {
        return $this->channelCategoryLabels;
    }

    public function addChannelCategoryLabel(ChannelCategoryLabel $channelCategoryLabel): self
    {
        if (!$this->channelCategoryLabels->contains($channelCategoryLabel)) {
            $this->channelCategoryLabels[] = $channelCategoryLabel;
            $channelCategoryLabel->setChannel($this);
        }

        return $this;
    }

    public function removeChannelCategoryLabel(ChannelCategoryLabel $channelCategoryLabel): self
    {
        if ($this->channelCategoryLabels->removeElement($channelCategoryLabel)) {
            // set the owning side to null (unless already changed)
            if ($channelCategoryLabel->getChannel() === $this) {
                $channelCategoryLabel->setChannel(null);
            }
        }

        return $this;
    }
}
