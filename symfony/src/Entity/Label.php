<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LabelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *      shortName="All Labels",
 *      collectionOperations={"get"={"path"="/labels"}},
 *      itemOperations={"get"={"path"="/label/{id}"}}
 * )
 * @ORM\Entity(repositoryClass=LabelRepository::class)
 */
class Label
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
     * @ORM\OneToMany(targetEntity=VideoLabel::class, mappedBy="label", orphanRemoval=true)
     */
    private $videoLabels;

    /**
     * @ORM\OneToMany(targetEntity=ChannelLabel::class, mappedBy="label", orphanRemoval=true)
     */
    private $channelLabels;

    public function __construct()
    {
        $this->videoLabels = new ArrayCollection();
        $this->channelLabels = new ArrayCollection();
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
            $videoLabel->setLabel($this);
        }

        return $this;
    }

    public function removeVideoLabel(VideoLabel $videoLabel): self
    {
        if ($this->videoLabels->removeElement($videoLabel)) {
            // set the owning side to null (unless already changed)
            if ($videoLabel->getLabel() === $this) {
                $videoLabel->setLabel(null);
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
            $channelLabel->setLabel($this);
        }

        return $this;
    }

    public function removeChannelLabel(ChannelLabel $channelLabel): self
    {
        if ($this->channelLabels->removeElement($channelLabel)) {
            // set the owning side to null (unless already changed)
            if ($channelLabel->getLabel() === $this) {
                $channelLabel->setLabel(null);
            }
        }

        return $this;
    }
}
