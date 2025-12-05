<?php

declare(strict_types=1);

namespace App\Controller;

use JulienLinard\Core\Controller\Controller;
use JulienLinard\Router\Attributes\Route;
use JulienLinard\Router\Response;
use JulienLinard\Core\Session\Session;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Pizza;
use App\Entity\Size;
use JulienLinard\Doctrine\EntityManager;

class OrderController extends Controller
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Liste des commandes du client connecté
     */
    #[Route(path: '/mes-commandes', methods: ['GET'], name: 'orders_index')]
    public function index(): Response
    {
        // 1. Sécurité
        $userSession = Session::get('user');
        if (!$userSession) {
            return $this->redirect('/login');
        }

        // 2. Récupérer les commandes du client
        // On trie par ID décroissant (les plus récentes en premier)
        $orders = $this->entityManager->getRepository(Order::class)->findBy(
            ['user_id' => $userSession['id']], 
            ['id' => 'DESC']
        );

        return $this->view('orders/index', [
            'title' => 'Mes Commandes',
            'orders' => $orders
        ]);
    }

    /**
     * Détail d'une commande spécifique
     */
    #[Route(path: '/mes-commandes/{id}', methods: ['GET'], name: 'orders_show')]
    public function show(int $id): Response
    {
        $userSession = Session::get('user');
        if (!$userSession) return $this->redirect('/login');

        // 1. Récupérer la commande
        $order = $this->entityManager->getRepository(Order::class)->find($id);

        // 2. Vérifier que la commande appartient bien à ce client !
        if (!$order || $order->getUserId() !== $userSession['id']) {
            Session::flash('error', 'Commande introuvable.');
            return $this->redirect('/mes-commandes');
        }

        // 3. Récupérer le contenu de la commande (Les pizzas)
        $orderItemsEntities = $this->entityManager->getRepository(OrderItem::class)->findBy(['order_id' => $id]);
        
        // On prépare les données détaillées (Nom de la pizza, Taille...)
        $details = [];
        foreach ($orderItemsEntities as $item) {
            $pizza = $this->entityManager->getRepository(Pizza::class)->find($item->getPizzaId());
            $size = $this->entityManager->getRepository(Size::class)->find($item->getSizeId());
            
            if ($pizza && $size) {
                $details[] = [
                    'pizza_name' => $pizza->getName(),
                    'image_url' => $pizza->getImageUrl(),
                    'size_label' => $size->getLabel(),
                    'quantity' => $item->getQuantity(),
                    'price' => $item->getPriceAtOrder(),
                    'total' => $item->getPriceAtOrder() * $item->getQuantity()
                ];
            }
        }

        return $this->view('orders/show', [
            'title' => 'Commande #' . $order->getId(),
            'order' => $order,
            'items' => $details
        ]);
    }
}