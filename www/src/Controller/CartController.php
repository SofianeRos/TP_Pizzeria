<?php

declare(strict_types=1);

namespace App\Controller;

use JulienLinard\Core\Controller\Controller;
use JulienLinard\Router\Attributes\Route;
use JulienLinard\Router\Response;
use JulienLinard\Core\Session\Session;
use App\Service\CartService;

class CartController extends Controller
{
    private CartService $cartService;

    // On injecte le CartService qu'on a créé précédemment
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Affiche le panier
     */
    #[Route(path: '/panier', methods: ['GET'], name: 'cart_index')]
    public function index(): Response
    {
        $details = $this->cartService->getDetailedCart();

        return $this->view('cart/index', [
            'title' => 'Mon Panier',
            'items' => $details['items'],
            'total' => $details['total']
        ]);
    }

    /**
     * Ajoute une pizza au panier (Action du formulaire)
     */
    #[Route(path: '/panier/add', methods: ['POST'], name: 'cart_add')]
    public function add(): Response
    {
        // On force la conversion en entier (int) pour la sécurité
        $pizzaId = (int)($_POST['pizza_id'] ?? 0);
        $sizeId = (int)($_POST['size_id'] ?? 0);
        $quantity = (int)($_POST['quantity'] ?? 1);

        if ($pizzaId > 0 && $sizeId > 0) {
            $this->cartService->add($pizzaId, $sizeId, $quantity);
            Session::flash('success', 'Pizza ajoutée au panier !');
        } else {
            Session::flash('error', 'Erreur : Impossible d\'ajouter ce produit.');
        }

        return $this->redirect('/panier');
    }

    /**
     * Supprime une ligne du panier
     * 
     */
    #[Route(path: '/panier/remove/{pizzaId}/{sizeId}', methods: ['GET'], name: 'cart_remove')]
    public function remove(int $pizzaId, int $sizeId): Response
    {
        $this->cartService->remove($pizzaId, $sizeId);
        Session::flash('success', 'Produit retiré du panier.');
        
        return $this->redirect('/panier');
    }

    /**
     * Vide entièrement le panier
     */
    #[Route(path: '/panier/clear', methods: ['GET'], name: 'cart_clear')]
    public function clear(): Response
    {
        $this->cartService->clear();
        Session::flash('success', 'Panier vidé.');
        
        return $this->redirect('/panier');
    }
}