<?php

namespace App\Dto;

use Doctrine\ORM\Mapping as ORM;

final class DataOutput {
    
    /**
     * @ORM\Column(type="array")
     */
    public $data;
    
    public function getData(): ?array
    {
        return $this->data;
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }
}