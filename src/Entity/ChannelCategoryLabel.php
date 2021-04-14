<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ChannelCategoryLabelRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ChannelCategoryLabelRepository::class)
 */
class ChannelCategoryLabel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Channel::class, inversedBy="channelCategoryLabels")
     * @ORM\JoinColumn(nullable=false)
     */
    private $channel;

    /**
     * @ORM\ManyToOne(targetEntity=ChannelCategory::class, inversedBy="channelCategoryLabels")
     * @ORM\JoinColumn(nullable=false)
     */
    private $channelCategory;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getChannelCategory(): ?ChannelCategory
    {
        return $this->channelCategory;
    }

    public function setChannelCategory(?ChannelCategory $channelCategory): self
    {
        $this->channelCategory = $channelCategory;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
