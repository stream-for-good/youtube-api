<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CaptionRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Dto\DataOutput;

/**
 * @ApiResource(
 *      shortName="All Captions",
 *      collectionOperations={
 *          "get"={
 *              "output"=DataOutput::class,
 *              "path"="/captions",
 *              "formats"={"json"}
 *          }
 *      },
 *      itemOperations={
 *          "get"={
 *              "output"=DataOutput::class,
 *              "path"="/caption/{id}",
 *              "formats"={"json"}
 *           }
 *      }
 * )
 * @ORM\Entity(repositoryClass=CaptionRepository::class)
 */
class Caption
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Video::class, inversedBy="caption", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $video;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getVideo(): ?Video
    {
        return $this->video;
    }

    public function setVideo(Video $video): self
    {
        $this->video = $video;

        return $this;
    }
}
