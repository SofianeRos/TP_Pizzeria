<?php

declare(strict_types=1);

namespace App\Controller;

use JulienLinard\Core\Controller\Controller;
use JulienLinard\Router\Attributes\Route;
use JulienLinard\Router\Response;
use JulienLinard\Core\Session\Session;
use App\Service\CartService;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\User;
use JulienLinard\Doctrine\EntityManager;

class CheckoutController extends Controller
{
    private EntityManager $entityManager;
    private CartService $cartService;

    public function __construct(EntityManager $entityManager, CartService $cartService)
    {
        $this->entityManager = $entityManager;
        $this->cartService = $cartService;
    }

    /**
     * Étape 1 : Formulaire de livraison
     */
    #[Route(path: '/commande/livraison', methods: ['GET'], name: 'checkout_index')]
    public function index(): Response
    {
        // 1. On récupère la session (C'est un TABLEAU [id, email...])
        $userSession = Session::get('user');
        if (!$userSession) {
            Session::flash('error', 'Veuillez vous connecter pour commander.');
            return $this->redirect('/login');
        }

        // 2. Vérifier si le panier n'est pas vide
        $cartDetails = $this->cartService->getDetailedCart();
        if (empty($cartDetails['items'])) {
            return $this->redirect('/panier');
        }

        // 3. RECUPERATION CRUCIALE DE L'OBJET
        // On utilise l'ID pour charger le VRAI objet User depuis la base de données
        // Cela nous permet d'avoir accès aux méthodes comme getAddress(), getZipcode(), etc.
        $userObject = $this->entityManager->getRepository(User::class)->find($userSession['id']);

        // Sécurité si l'utilisateur n'est pas trouvé
        if (!$userObject) {
            Session::remove('user'); 
            return $this->redirect('/login');
        }

        // 4. Envoi à la vue
    
        return $this->view('checkout/index', [
            'title' => 'Livraison',
            'customer' => $userObject, // On passe l'OBJET chargé
            'total' => $cartDetails['total']
        ]);
    }

    /**
     * Étape 2 : Validation et Enregistrement
     */
    #[Route(path: '/commande/validate', methods: ['POST'], name: 'checkout_validate')]
    public function validate(): Response
    {
        $userSession = Session::get('user');
        if (!$userSession) return $this->redirect('/login');

        // Données du formulaire
        $address = $_POST['address'] ?? '';
        $zipcode = $_POST['zipcode'] ?? '';
        $city = $_POST['city'] ?? '';
        $phone = $_POST['phone'] ?? '';

        if (empty($address) || empty($zipcode) || empty($city) || empty($phone)) {
            Session::flash('error', 'Tous les champs sont obligatoires.');
            return $this->redirect('/commande/livraison');
        }

        $cartDetails = $this->cartService->getDetailedCart();
        if (empty($cartDetails['items'])) return $this->redirect('/panier');

        // Création de la commande
        $order = new Order();
        $order->setUserId((int)$userSession['id']);
        $order->setTotalPrice($cartDetails['total']);
        $order->setStatus('EN_PREPARATION');
        
        $order->setDeliveryAddress($address);
        $order->setDeliveryZipcode($zipcode);
        $order->setDeliveryCity($city);
        $order->setDeliveryPhone($phone);

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        // Enregistrement des pizzas
        foreach ($cartDetails['items'] as $item) {
            $orderItem = new OrderItem();
            $orderItem->setOrderId($order->getId());
            $orderItem->setPizzaId($item['pizza']->getId());
            $orderItem->setSizeId($item['size']->getId());
            $orderItem->setQuantity($item['quantity']);
            $orderItem->setPriceAtOrder($item['price']);

            $this->entityManager->persist($orderItem);
        }

        // Mise à jour du profil utilisateur (Bonus)
        // On recharge l'objet pour pouvoir le modifier proprement
        $userEntity = $this->entityManager->getRepository(User::class)->find($userSession['id']);
        
        if ($userEntity && empty($userEntity->getAddress())) {
            $userEntity->setAddress($address);
            $userEntity->setZipcode($zipcode);
            $userEntity->setCity($city);
            $userEntity->setPhone($phone);
            $this->entityManager->persist($userEntity);
        }

        $this->entityManager->flush();
        $this->cartService->clear();

        return $this->redirect('/commande/merci');
    }

    #[Route(path: '/commande/merci', methods: ['GET'], name: 'checkout_success')]
    public function success(): Response
    {
        return $this->view('checkout/success', [
            'title' => 'Commande confirmée'
        ]);
    }
}