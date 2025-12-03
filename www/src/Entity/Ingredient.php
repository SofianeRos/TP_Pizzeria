<?php

namespace App\Entity;

use DateTime;
use JulienLinard\Doctrine\Mapping\Column;
use JulienLinard\Doctrine\Mapping\Entity;
use JulienLinard\Doctrine\Mapping\Id;
use JulienLinard\Doctrine\Mapping\ManyToOne;


#[Entity(table: 'ingredients')]

class Ingredient

{

    #[Id]

    #[Column(type: 'int')]

    private int $id;

    #[Column(type: 'string')]

    private string $name;

    #[Column(name: 'stock_quantity', type: 'int')]

    private int $stockQuantity = 0;

    // --- Getters et Setters ---

    public function getId(): int { return $this->id; }

    public function getName(): string { return $this->name; }

    public function setName(string $name): self { 

        $this->name = $name; 

        return $this; 

    }

    public function getStockQuantity(): int { return $this->stockQuantity; }

    public function setStockQuantity(int $stockQuantity): self { 

        $this->stockQuantity = $stockQuantity; 

        return $this; 

    }

}
 