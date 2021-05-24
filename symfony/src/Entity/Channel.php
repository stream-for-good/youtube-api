<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ChannelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ChannelRepository::class)
 * @UniqueEntity("id")
 */
class Channel
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255, unique=true)
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=VideoInfo::class, mappedBy="channel")
     */
    private $videoInfos;

    /**
     * @ORM\OneToMany(targetEntity=ChannelLabel::class, mappedBy="channel", orphanRemoval=true)
     */
    private $channelLabels;

    public function __construct()
    {
        $this->videoInfos = new ArrayCollection();
        $this->channelLabels = new ArrayCollection();
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
            $videoInfo->setChannel($this);
        }

        return $this;
    }

    public function removeVideoInfo(VideoInfo $videoInfo): self
    {
        if ($this->videoInfos->removeElement($videoInfo)) {
            // set the owning side to null (unless already changed)
            if ($videoInfo->getChannel() === $this) {
                $videoInfo->setChannel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ChannelLabel[]
     */
    public function getChannelLabels(): Collection
    {
        return $this->channelLabels;
    }

    public function addChannelLabel(ChannelLabel $channelLabel): self
    {
        if (!$this->channelLabels->contains($channelLabel)) {
            $this->channelLabels[] = $channelLabel;
            $channelLabel->setChannel($this);
        }

        return $this;
    }

    public function removeChannelLabel(ChannelLabel $channelLabel): self
    {
        if ($this->channelLabels->removeElement($channelLabel)) {
            // set the owning side to null (unless already changed)
            if ($channelLabel->getChannel() === $this) {
                $channelLabel->setChannel(null);
            }
        }

        return $this;
    }
}
