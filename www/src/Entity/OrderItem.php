<?php

namespace App\Entity;

use DateTime;
use JulienLinard\Doctrine\Mapping\Column;
use JulienLinard\Doctrine\Mapping\Entity;
use JulienLinard\Doctrine\Mapping\Id;
use JulienLinard\Doctrine\Mapping\ManyToOne;

#[Entity(table: 'order_items')]
class OrderItem
{
    #[Id]
    #[Column(type: 'int')]
    private ?int $id = null;

    #[Column(name: 'order_id', type: 'int')]
    private int $orderId;

    #[Column(name: 'pizza_id', type: 'int')]
    private int $pizzaId;

    #[Column(name: 'size_id', type: 'int')]
    private int $sizeId;

    #[Column(type: 'int')]
    private int $quantity;

    #[Column(name: 'price_at_order', type: 'string')]
    private string $priceAtOrder;

    // --- Getters et Setters ---

    public function getId(): ?int { return $this->id; }

    public function getOrderId(): int { return $this->orderId; }
    public function setOrderId(int $orderId): self { $this->orderId = $orderId; return $this; }

    public function getPizzaId(): int { return $this->pizzaId; }
    public function setPizzaId(int $pizzaId): self { $this->pizzaId = $pizzaId; return $this; }

    public function getSizeId(): int { return $this->sizeId; }
    public function setSizeId(int $sizeId): self { $this->sizeId = $sizeId; return $this; }

    public function getQuantity(): int { return $this->quantity; }
    public function setQuantity(int $quantity): self { $this->quantity = $quantity; return $this; }

    public function getPriceAtOrder(): float { return (float)$this->priceAtOrder; }
    public function setPriceAtOrder(float $price): self { $this->priceAtOrder = (string)$price; return $this; }
}