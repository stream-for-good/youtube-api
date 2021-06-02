<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CaptureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Dto\DataOutput;

/**
 * @ApiResource(
 *      shortName="All Captures",
 *      collectionOperations={
 *          "get"={
 *              "output"=DataOutput::class,
 *              "path"="/captures",
 *              "formats"={"json"}
 *          }
 *      },
 *      itemOperations={
 *          "get"={
 *              "output"=DataOutput::class,
 *              "path"="/capture/{id}",
 *              "formats"={"json"}
 *           }
 *      }
 * )
 * @ORM\Entity(repositoryClass=CaptureRepository::class)
 */
class Capture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Log::class, inversedBy="captures")
     * @ORM\JoinColumn(nullable=false)
     * @ORM\JoinColumn(onDelete="CASCADE") 
     */
    private $log;

    /**
     * @ORM\ManyToOne(targetEntity=Video::class, inversedBy="captures")
     * @ORM\JoinColumn(nullable=false)
     * @ORM\JoinColumn(onDelete="CASCADE") 
     */
    private $video;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $position;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLog(): ?Log
    {
        return $this->log;
    }

    public function setLog(?Log $log): self
    {
        $this->log = $log;

        return $this;
    }

    public function getVideo(): ?Video
    {
        return $this->video;
    }

    public function setVideo(?Video $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }

}
