<?php

namespace App\Dto;

use Doctrine\ORM\Mapping as ORM;

final class SessionOutput {
    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    public $id;

    /**
     * @ORM\Column(type="email", length=255, unique=false)
     */
    public $email;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

}