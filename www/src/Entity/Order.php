<?php

namespace App\Entity;

use DateTime;
use JulienLinard\Doctrine\Mapping\Column;
use JulienLinard\Doctrine\Mapping\Entity;
use JulienLinard\Doctrine\Mapping\Id;
use JulienLinard\Doctrine\Mapping\ManyToOne;

#[Entity(table: 'orders')]
class Order
{
    #[Id]
    #[Column(type: 'int')]
    private ?int $id = null;

    #[Column(name: 'user_id', type: 'int')]
    private int $userId;

    #[Column(type: 'string')]
    private string $status = 'EN_PREPARATION'; // Statut par défaut

    #[Column(name: 'total_price', type: 'string')]
    private string $totalPrice;

    #[Column(name: 'created_at', type: 'string')]
    private string $createdAt;

    // --- Champs de Livraison ---
    #[Column(name: 'delivery_address', type: 'string')]
    private string $deliveryAddress;

    #[Column(name: 'delivery_zipcode', type: 'string')]
    private string $deliveryZipcode;

    #[Column(name: 'delivery_city', type: 'string')]
    private string $deliveryCity;

    #[Column(name: 'delivery_phone', type: 'string')]
    private string $deliveryPhone;

    public function __construct()
    {
        // On fixe la date automatiquement à la création
        $this->createdAt = date('Y-m-d H:i:s');
    }

    // --- Getters et Setters ---

    public function getId(): ?int { return $this->id; }

    public function getUserId(): int { return $this->userId; }
    public function setUserId(int $userId): self { $this->userId = $userId; return $this; }

    public function getStatus(): string { return $this->status; }
    public function setStatus(string $status): self { $this->status = $status; return $this; }

    public function getTotalPrice(): float { return (float)$this->totalPrice; }
    public function setTotalPrice(float $totalPrice): self { $this->totalPrice = (string)$totalPrice; return $this; }

    public function getCreatedAt(): string { return $this->createdAt; }
    
    // Getters Livraison
    public function getDeliveryAddress(): string { return $this->deliveryAddress; }
    public function setDeliveryAddress(string $address): self { $this->deliveryAddress = $address; return $this; }

    public function getDeliveryZipcode(): string { return $this->deliveryZipcode; }
    public function setDeliveryZipcode(string $zipcode): self { $this->deliveryZipcode = $zipcode; return $this; }

    public function getDeliveryCity(): string { return $this->deliveryCity; }
    public function setDeliveryCity(string $city): self { $this->deliveryCity = $city; return $this; }

    public function getDeliveryPhone(): string { return $this->deliveryPhone; }
    public function setDeliveryPhone(string $phone): self { $this->deliveryPhone = $phone; return $this; }
}