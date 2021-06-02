<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ChannelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Dto\DataOutput;

/**
 * @ApiResource(
 *      shortName="All Channels",
 *      collectionOperations={
 *          "get"={
 *              "output"=DataOutput::class,
 *              "path"="/channels",
 *              "formats"={"json"}
 *          }
 *      },
 *      itemOperations={
 *          "get"={
 *              "output"=DataOutput::class,
 *              "path"="/channel/{id}",
 *              "formats"={"json"}
 *           }
 *      }
 * )
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
     * @ORM\OneToMany(targetEntity=Video::class, mappedBy="channel")
     */
    private $videos;

    /**
     * @ORM\OneToOne(targetEntity=ChannelLabel::class, mappedBy="channel", cascade={"persist", "remove"})
     */
    private $channelLabel;

    public function __construct()
    {
        $this->videos = new ArrayCollection();
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

    public function getChannelLabel(): ?ChannelLabel
    {
        return $this->channelLabel;
    }

    public function setChannelLabel(ChannelLabel $channelLabel): self
    {
        // set the owning side of the relation if necessary
        if ($channelLabel->getChannel() !== $this) {
            $channelLabel->setChannel($this);
        }

        $this->channelLabel = $channelLabel;

        return $this;
    }
}
