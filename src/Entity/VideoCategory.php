<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\VideoCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=VideoCategoryRepository::class)
 */
class VideoCategory
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
     * @ORM\OneToMany(targetEntity=VideoCategoryLabel::class, mappedBy="videoCategory", orphanRemoval=true)
     */
    private $videoCategoryLabels;

    public function __construct()
    {
        $this->videoCategoryLabels = new ArrayCollection();
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
            $videoCategoryLabel->setVideoCategory($this);
        }

        return $this;
    }

    public function removeVideoCategoryLabel(VideoCategoryLabel $videoCategoryLabel): self
    {
        if ($this->videoCategoryLabels->removeElement($videoCategoryLabel)) {
            // set the owning side to null (unless already changed)
            if ($videoCategoryLabel->getVideoCategory() === $this) {
                $videoCategoryLabel->setVideoCategory(null);
            }
        }

        return $this;
    }
}
