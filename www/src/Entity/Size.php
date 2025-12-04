<?php

namespace App\Entity;

use DateTime;
use JulienLinard\Doctrine\Mapping\Column;
use JulienLinard\Doctrine\Mapping\Entity;
use JulienLinard\Doctrine\Mapping\Id;
use JulienLinard\Doctrine\Mapping\ManyToOne;
#[Entity(table: 'sizes')]
class Size
{
    #[Id]
    #[Column(type: 'int')]
    private ?int $id = null;

    #[Column(type: 'string')]
    private string $label;

    public function getId(): ?int { return $this->id; }
    
    public function getLabel(): string { return $this->label; }
    public function setLabel(string $label): self { 
        $this->label = $label; 
        return $this; 
    }
}