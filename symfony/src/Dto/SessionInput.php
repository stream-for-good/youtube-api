<?php

namespace App\Dto;

use Doctrine\ORM\Mapping as ORM;

final class SessionInput {
    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    public $id;

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