<?php

namespace App\Service;

use JulienLinard\Core\Session\Session;
use JulienLinard\Doctrine\EntityManager;
use App\Entity\Pizza;
use App\Entity\Size;
use App\Entity\PizzaPrice;

class CartService
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Ajoute une pizza au panier
     */
    public function add(int $pizzaId, int $sizeId, int $quantity = 1): void
    {
        $cart = Session::get('cart', []);
        
        // Clé unique pour identifier le produit 
        $key = $pizzaId . '-' . $sizeId;

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $quantity;
        } else {
            $cart[$key] = [
                'pizza_id' => $pizzaId,
                'size_id' => $sizeId,
                'quantity' => $quantity
            ];
        }

        Session::set('cart', $cart);
    }

    /**
     * Supprime une pizza du panier
     */
    public function remove(int $pizzaId, int $sizeId): void
    {
        $cart = Session::get('cart', []);
        $key = $pizzaId . '-' . $sizeId;

        if (isset($cart[$key])) {
            unset($cart[$key]);
        }

        Session::set('cart', $cart);
    }

    /**
     * Vide le panier
     */
    public function clear(): void
    {
        Session::remove('cart');
    }

    /**
     * Récupère le panier complet avec les objets (Pizza, Taille) et le prix total
     */
    public function getDetailedCart(): array
    {
        $cart = Session::get('cart', []);
        $detailedCart = [];
        $total = 0;

        foreach ($cart as $item) {
            $pizza = $this->entityManager->getRepository(Pizza::class)->find($item['pizza_id']);
            $size = $this->entityManager->getRepository(Size::class)->find($item['size_id']);
            
            // Chercher le prix correspondant
            $priceEntity = $this->entityManager->getRepository(PizzaPrice::class)->findOneBy([
                'pizza_id' => $item['pizza_id'],
                'size_id' => $item['size_id']
            ]);

            // Si un des éléments n'existe plus (ex: pizza supprimée), on ignore
            if (!$pizza || !$size || !$priceEntity) {
                continue;
            }

            $price = $priceEntity->getPrice();
            $subTotal = $price * $item['quantity'];
            $total += $subTotal;

            $detailedCart[] = [
                'pizza' => $pizza,
                'size' => $size,
                'quantity' => $item['quantity'],
                'price' => $price,
                'total' => $subTotal
            ];
        }

        return [
            'items' => $detailedCart,
            'total' => $total
        ];
    }
}