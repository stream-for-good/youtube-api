<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Dto\DataOutput;
use App\Dto\LogsInput;

/**
 * @ApiResource(
 *      shortName="All Logs",
 *      collectionOperations={
 *          "post"={
 *          "input"=LogsInput::class,
 *          "output"=LogsInput::class,
 *          "path"="/log/new"
 *          },
 *          "get"={
 *              "output"=DataOutput::class,
 *              "path"="/logs",
 *              "formats"={"json"}
 *          }
 *      },
 *      itemOperations={
 *          "get"={
 *              "output"=DataOutput::class,
 *              "path"="/log/{id}",
 *              "formats"={"json"}
 *           }
 *      }
 * )
 * @ORM\Entity(repositoryClass=LogRepository::class)
 */
class Log
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Session::class, inversedBy="logs")
     * @ORM\JoinColumn(nullable=false,referencedColumnName="id")
     */
    private $session;

    /**
     * @ORM\OneToMany(targetEntity=Capture::class, mappedBy="log", orphanRemoval=true)
     */
    private $captures;

    /**
     * @ORM\ManyToOne(targetEntity=Action::class, inversedBy="logs")
     * @ORM\JoinColumn(nullable=false)
     * @ORM\JoinColumn(onDelete="CASCADE") 
     */
    private $action;

    /**
     * @ORM\ManyToOne(targetEntity=Video::class, inversedBy="logs")
     * @ORM\JoinColumn(onDelete="CASCADE") 
     */
    private $currentVideo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $words;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $actionNumber;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $indexVideo;

    public function __construct()
    {
        $this->captures = new ArrayCollection();
        $this->createAt=new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): self
    {
        $this->session = $session;

        return $this;
    }

    /**
     * @return Collection|Capture[]
     */
    public function getCaptures(): Collection
    {
        return $this->captures;
    }

    public function addCapture(Capture $capture): self
    {
        if (!$this->captures->contains($capture)) {
            $this->captures[] = $capture;
            $capture->setLog($this);
        }

        return $this;
    }

    public function removeCapture(Capture $capture): self
    {
        if ($this->captures->removeElement($capture)) {
            // set the owning side to null (unless already changed)
            if ($capture->getLog() === $this) {
                $capture->setLog(null);
            }
        }

        return $this;
    }

    public function getAction(): ?Action
    {
        return $this->action;
    }

    public function setAction(?Action $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getCurrentVideo(): ?Video
    {
        return $this->currentVideo;
    }

    public function setCurrentVideo(?Video $currentVideo): self
    {
        $this->currentVideo = $currentVideo;

        return $this;
    }

    public function getCreateAt(): ?\DateTime
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTime $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getWords(): ?string
    {
        return $this->words;
    }

    public function setWords(?string $words): self
    {
        $this->words = $words;

        return $this;
    }

    public function getActionNumber(): ?int
    {
        return $this->actionNumber;
    }

    public function setActionNumber(?int $actionNumber): self
    {
        $this->actionNumber = $actionNumber;

        return $this;
    }

    public function getIndexVideo(): ?int
    {
        return $this->indexVideo;
    }

    public function setIndexVideo(?int $indexVideo): self
    {
        $this->indexVideo = $indexVideo;

        return $this;
    }
}
