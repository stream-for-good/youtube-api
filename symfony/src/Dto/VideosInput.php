<?php

namespace App\Dto;

use Doctrine\ORM\Mapping as ORM;

final class VideosInput {
    /**
     * @ORM\Column(type="array")
     */
    public $items;

    public function getItems(): ?array
    {
        return $this->items;
    }
    public function setItems(array $items): self
    {
        $this->items = $items;

        return $this;
    }
}