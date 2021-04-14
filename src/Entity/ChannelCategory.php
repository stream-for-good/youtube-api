<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ChannelCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ChannelCategoryRepository::class)
 */
class ChannelCategory
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
     * @ORM\OneToMany(targetEntity=ChannelCategoryLabel::class, mappedBy="channelCategory", orphanRemoval=true)
     */
    private $channelCategoryLabels;

    public function __construct()
    {
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
            $channelCategoryLabel->setChannelCategory($this);
        }

        return $this;
    }

    public function removeChannelCategoryLabel(ChannelCategoryLabel $channelCategoryLabel): self
    {
        if ($this->channelCategoryLabels->removeElement($channelCategoryLabel)) {
            // set the owning side to null (unless already changed)
            if ($channelCategoryLabel->getChannelCategory() === $this) {
                $channelCategoryLabel->setChannelCategory(null);
            }
        }

        return $this;
    }
}
