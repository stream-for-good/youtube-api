<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Dto\DataOutput;
use App\Dto\SessionInput;

/**
 * @ApiResource(
 *      shortName="All Sessions",
 *      collectionOperations={
 *          "post"={
 *          "output"=SessionInput::class,
 *          "path"="/session/new"
 *          },
 *          "get"={
 *              "output"=DataOutput::class,
 *              "path"="/sessions",
 *              "formats"={"json"}
 *          }
 *      },
 *      itemOperations={
 *          "get"={
 *              "output"=DataOutput::class,
 *              "path"="/session/{id}",
 *              "formats"={"json"}
 *           }
 *      }
 * )
 * @ORM\Entity(repositoryClass=SessionRepository::class)
 * @UniqueEntity("id")
 */
class Session
{

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255, unique=true)
     * @ORM\GeneratedValue(strategy="NONE")
     */

    private $id;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createAt;

    /**
     * @ORM\OneToMany(targetEntity=Log::class, mappedBy="session", orphanRemoval=true)
     */
    private $logs;

    public function __construct()
    {
        $this->createAt=new \DateTime();
        $this->logs = new ArrayCollection();
    }

    public function getCreateAt(): ?\DateTime
    {
        return $this->createAt;
    }

    public function setCreateAt(?\DateTime $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * @return Collection|Log[]
     */
    public function getLogs(): Collection
    {
        return $this->logs;
    }

    public function addLog(Log $log): self
    {
        if (!$this->logs->contains($log)) {
            $this->logs[] = $log;
            $log->setSession($this);
        }

        return $this;
    }

    public function removeLog(Log $log): self
    {
        if ($this->logs->removeElement($log)) {
            // set the owning side to null (unless already changed)
            if ($log->getSession() === $this) {
                $log->setSession(null);
            }
        }

        return $this;
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
}
