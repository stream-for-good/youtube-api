<?php

namespace App\Dto;

use Doctrine\ORM\Mapping as ORM;

final class LinksOutput {
    
    /**
     * @ORM\Column(type="array")
     */
    public $links;

    public function getLinks(): ?array
    {
        return $this->links;
    }

    public function setLinks(array $links): self
    {
        $this->links = $links;

        return $this;
    }
}