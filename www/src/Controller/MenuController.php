<?php

declare(strict_types=1);

namespace App\Controller;

use JulienLinard\Core\Controller\Controller;
use JulienLinard\Router\Attributes\Route;
use JulienLinard\Router\Response;
use App\Entity\Pizza;
use App\Entity\PizzaPrice;
use App\Entity\Size;
use JulienLinard\Doctrine\EntityManager;

class MenuController extends Controller
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Liste des pizzas (La Carte)
     */
    #[Route(path: '/carte', methods: ['GET'], name: 'menu_list')]
    public function index(): Response
    {
        $pizzas = $this->entityManager->getRepository(Pizza::class)->findAll();

        return $this->view('pizzas/index', [
            'title' => 'Notre Carte',
            'pizzas' => $pizzas
        ]);
    }
    
    /**
     * Détail d'une pizza (Page avec le formulaire d'achat)
     */
    #[Route(path: '/carte/{id}', methods: ['GET'], name: 'menu_show')]
    public function show(int $id): Response
    {
        // 1. On récupère la pizza
        $pizza = $this->entityManager->getRepository(Pizza::class)->find($id);

        if (!$pizza) {
            return $this->redirect('/carte');
        }

        // 2. On récupère tous les tarifs pour cette pizza
        $pizzaPrices = $this->entityManager->getRepository(PizzaPrice::class)->findBy(['pizza_id' => $id]);
        
        // 3. On construit un tableau propre pour la vue 
        $options = [];
        foreach ($pizzaPrices as $priceEntity) {
            $size = $this->entityManager->getRepository(Size::class)->find($priceEntity->getSizeId());
            
            if ($size) {
                $options[] = [
                    'size_id' => $size->getId(),
                    'label' => $size->getLabel(), 
                    'price' => $priceEntity->getPrice() 
                ];
            }
        }
        
        // On trie du moins cher au plus cher
        usort($options, fn($a, $b) => $a['price'] <=> $b['price']);

        return $this->view('pizzas/show', [
            'title' => $pizza->getName(),
            'pizza' => $pizza,
            'options' => $options
        ]);
    }
}