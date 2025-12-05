<?php

declare(strict_types=1);

namespace App\Controller;

use JulienLinard\Core\Controller\Controller;
use JulienLinard\Router\Attributes\Route;
use JulienLinard\Router\Response;
use JulienLinard\Core\Session\Session;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\User;
use App\Entity\Pizza;
use App\Entity\Size;
use JulienLinard\Doctrine\EntityManager;

class AdminOrderController extends Controller
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Liste de toutes les commandes (Dashboard)
     */
    #[Route(path: '/admin/orders', methods: ['GET'], name: 'admin_orders_index')]
    public function index(): Response
    {
        // 1. Sécurité
        $user = Session::get('user');
        if (!$user || $user['role'] !== 'GERANT') {
            return $this->redirect('/login');
        }

        // 2. Récupérer TOUTES les commandes (du plus récent au plus vieux)
        $orders = $this->entityManager->getRepository(Order::class)->findBy([], ['id' => 'DESC']);

        // 3. Récupérer les noms des clients
        $ordersWithUser = [];
        foreach ($orders as $order) {
            $client = $this->entityManager->getRepository(User::class)->find($order->getUserId());
            $ordersWithUser[] = [
                'order' => $order,
                'client_name' => $client ? ($client->getFirstname() . ' ' . $client->getLastname()) : 'Inconnu'
            ];
        }

        return $this->view('admin/order_index', [
            'title' => 'Gestion des Commandes',
            'ordersList' => $ordersWithUser
        ]);
    }

    /**
     * Détail d'une commande + Modification statut
     */
    #[Route(path: '/admin/orders/{id}', methods: ['GET'], name: 'admin_orders_show')]
    public function show(int $id): Response
    {
        $user = Session::get('user');
        if (!$user || $user['role'] !== 'GERANT') {
            return $this->redirect('/login');
        }

        $order = $this->entityManager->getRepository(Order::class)->find($id);
        if (!$order) {
            return $this->redirect('/admin/orders');
        }

        // Infos Client
        $client = $this->entityManager->getRepository(User::class)->find($order->getUserId());

        // Détail des pizzas
        $orderItems = $this->entityManager->getRepository(OrderItem::class)->findBy(['order_id' => $id]);
        $itemsDetails = [];
        
        foreach ($orderItems as $item) {
            $pizza = $this->entityManager->getRepository(Pizza::class)->find($item->getPizzaId());
            $size = $this->entityManager->getRepository(Size::class)->find($item->getSizeId());
            
            if ($pizza && $size) {
                $itemsDetails[] = [
                    'pizza_name' => $pizza->getName(),
                    'size_label' => $size->getLabel(),
                    'quantity' => $item->getQuantity(),
                    'price' => $item->getPriceAtOrder()
                ];
            }
        }

        return $this->view('admin/order_show', [
            'title' => 'Commande #' . $order->getId(),
            'order' => $order,
            'client' => $client,
            'items' => $itemsDetails
        ]);
    }

    /**
     * Action pour changer le statut (VERSION BLINDÉE)
     */
    #[Route(path: '/admin/orders/{id}/status', methods: ['POST'], name: 'admin_orders_status')]
    public function updateStatus(int $id): Response
    {
        // 1. Sécurité
        $user = Session::get('user');
        if (!$user || $user['role'] !== 'GERANT') {
            return $this->redirect('/login');
        }

        $order = $this->entityManager->getRepository(Order::class)->find($id);
        
        if ($order) {
            $newStatus = $_POST['status'] ?? '';
            $allowed = ['EN_PREPARATION', 'EN_LIVRAISON', 'LIVREE', 'ANNULEE'];
            
            if (in_array($newStatus, $allowed)) {
                // A. On tente la méthode normale (ORM)
                $order->setStatus($newStatus);
                $this->entityManager->persist($order);
                $this->entityManager->flush();

                // B. PLAN DE SECOURS : FORCE BRUTE SQL
                // On force l'écriture en base pour être sûr à 100% que ça change
                try {
                    $dsn = 'mysql:host=' . getenv('MARIADB_CONTAINER') . ';dbname=' . getenv('MYSQL_DATABASE') . ';charset=utf8mb4';
                    $pdo = new \PDO($dsn, getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'));
                    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                    
                    $sql = "UPDATE orders SET status = :status WHERE id = :id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        ':status' => $newStatus,
                        ':id' => $id
                    ]);
                    
                } catch (\Exception $e) {
                    // Si ça échoue ici, c'est pas grave, on espère que l'ORM a fait le job
                }

                Session::flash('success', 'Statut mis à jour !');
            } else {
                Session::flash('error', 'Statut invalide.');
            }
        }

        return $this->redirect('/admin/orders/' . $id);
    }
}