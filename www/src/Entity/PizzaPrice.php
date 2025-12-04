<?php

namespace App\Entity;

use DateTime;
use JulienLinard\Doctrine\Mapping\Column;
use JulienLinard\Doctrine\Mapping\Entity;
use JulienLinard\Doctrine\Mapping\Id;
use JulienLinard\Doctrine\Mapping\ManyToOne;

#[Entity(table: 'pizza_prices')]
class PizzaPrice
{
    #[Id]
    #[Column(type: 'int')]
    private ?int $id = null;

    #[Column(name: 'pizza_id', type: 'int')]
    private int $pizzaId;

    #[Column(name: 'size_id', type: 'int')]
    private int $sizeId;

    #[Column(type: 'string')]
    private string $price;

    public function getId(): ?int { return $this->id; }
    
    public function getPizzaId(): int { return $this->pizzaId; }
    public function setPizzaId(int $pizzaId): self { $this->pizzaId = $pizzaId; return $this; }

    public function getSizeId(): int { return $this->sizeId; }
    public function setSizeId(int $sizeId): self { $this->sizeId = $sizeId; return $this; }

    public function getPrice(): float { return (float)$this->price; }
    public function setPrice(float $price): self { $this->price = (string)$price; return $this; }
}