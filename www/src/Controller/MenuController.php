<?php

declare(strict_types=1);

namespace App\Controller;

use JulienLinard\Core\Controller\Controller;

use JulienLinard\Router\Attributes\Route;

use JulienLinard\Router\Response;

use App\Entity\Pizza;

use JulienLinard\Doctrine\EntityManager;

class MenuController extends Controller

{

    // On déclare une propriété pour stocker l'EntityManager

    private EntityManager $entityManager;

    /**

     * Constructeur : On demande l'EntityManager ici.

     * Le framework va l'injecter automatiquement (Autowiring).

     */

    public function __construct(EntityManager $entityManager)

    {

        $this->entityManager = $entityManager;

    }

    #[Route(path: '/carte', methods: ['GET'], name: 'menu_list')]

    public function index(): Response

    {

        // On utilise $this->entityManager directement

        // Plus besoin de getContainer() !

        $pizzas = $this->entityManager->getRepository(Pizza::class)->findAll();

        return $this->view('pizzas/index', [

            'title' => 'Notre Carte',

            'pizzas' => $pizzas

        ]);

    }

    #[Route(path: '/carte/{id}', methods: ['GET'], name: 'menu_show')]

    public function show(int $id): Response

    {

        // Idem ici, on réutilise la propriété

        $pizza = $this->entityManager->getRepository(Pizza::class)->find($id);

        if (!$pizza) {

            return $this->redirect('/carte');

        }

        return $this->view('pizzas/show', [

            'pizza' => $pizza

        ]);

    }

}
 