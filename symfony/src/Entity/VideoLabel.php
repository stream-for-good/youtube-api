<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\VideoLabelRepository;
use App\Controller\VideoLabelController;
use Doctrine\ORM\Mapping as ORM;
use App\Dto\DataOutput;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ApiResource(
 *      shortName="All VideosLabel",
 *      collectionOperations={
 *          "get"={
 *              "output"=DataOutput::class,
 *              "path"="/videos/label",
 *              "formats"={"json"}
 *          }
 *      },
 *      itemOperations={
 *          "get"={
 *              "output"=DataOutput::class,
 *              "path"="/video/label/{id}",
 *              "formats"={"json"}
 *           },
 *          "patch"={
 *              "method"="PATCH",
 *              "path"="/video/label/{id}/update",
 *              "controller"=VideoLabelController::class ,
 *              "normalization_context"={"groups"={"patch"}},
 *              "input_formats"={"json"={"application/json" }},
 *              "output_formats"={"json"={ "application/json"}}
 *          },
 *      }
 * )
 * @ORM\Entity(repositoryClass=VideoLabelRepository::class)
 */
class VideoLabel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Video::class, inversedBy="videoLabel", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $video;
    
    /**
     * @ORM\ManyToOne(targetEntity=Label::class, inversedBy="videoLabels")
     * @ORM\JoinColumn(nullable=false)
     * @ORM\JoinColumn(onDelete="CASCADE") 
     * @Groups("patch")
     */
    private $label;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("patch")
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
