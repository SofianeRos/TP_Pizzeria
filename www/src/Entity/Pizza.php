<?php

namespace App\Entity;

use DateTime;
use JulienLinard\Doctrine\Mapping\Column;
use JulienLinard\Doctrine\Mapping\Entity;
use JulienLinard\Doctrine\Mapping\Id;
use JulienLinard\Doctrine\Mapping\ManyToOne;


#[Entity(table: 'pizzas')]
class Pizza
{
    #[Id]
    #[Column(type: 'int')]

    private ?int $id = null;

    #[Column(type: 'string')]
    private string $name;

    #[Column(type: 'string')]
    private ?string $description = null;

    #[Column(name: 'image_url', type: 'string')]
    private ?string $imageUrl = null;

    // --- Getters et Setters ---


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }
    public function setImageUrl(?string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }
}
