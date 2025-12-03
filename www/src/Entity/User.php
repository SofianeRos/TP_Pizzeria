<?php

namespace App\Entity;

use DateTime;
use JulienLinard\Auth\Models\Authenticatable;
use JulienLinard\Doctrine\Mapping\Id;
use JulienLinard\Doctrine\Mapping\Column;
use JulienLinard\Doctrine\Mapping\Entity;
use JulienLinard\Auth\Models\UserInterface;
use JulienLinard\Doctrine\Mapping\OneToMany;


#[Entity(table: 'users')]
class User
{
    #[Id]
    #[Column(type: 'int')]
    private int $id;
    #[Column(type: 'string')]
    private string $email;
    #[Column(type: 'string')]
    private string $password;
    #[Column(type: 'string')]
    private string $role = 'CLIENT'; // Valeur par défaut
    // --- Getters et Setters ---
    // (Indispensables pour que le framework puisse lire/écrire les données)
    public function getId(): int
    {
        return $this->id;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }
    public function getRole(): string
    {
        return $this->role;
    }
    public function setRole(string $role): self
    {
        $this->role = $role;
        return $this;
    }
}
