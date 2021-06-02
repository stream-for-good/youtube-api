<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ChannelLabelRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Dto\DataOutput;

/**
 * @ApiResource(
 *      shortName="All ChannelsLabel",
 *      collectionOperations={
 *          "get"={
 *              "output"=DataOutput::class,
 *              "path"="/channels/label",
 *              "formats"={"json"}
 *          }
 *      },
 *      itemOperations={
 *          "get"={
 *              "output"=DataOutput::class,
 *              "path"="/channel/label/{id}",
 *              "formats"={"json"}
 *           }
 *      }
 * )
 * @ORM\Entity(repositoryClass=ChannelLabelRepository::class)
 */
class ChannelLabel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Channel::class, inversedBy="channelLabel", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $channel;

    /**
     * @ORM\ManyToOne(targetEntity=Label::class, inversedBy="channelLabels")
     * @ORM\JoinColumn(nullable=false)
     * @ORM\JoinColumn(onDelete="CASCADE") 
     */
    private $label;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?Label
    {
        return $this->label;
    }

    public function setLabel(?Label $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getChannel(): ?Channel
    {
        return $this->channel;
    }

    public function setChannel(Channel $channel): self
    {
        $this->channel = $channel;

        return $this;
    }
}
