<?php

declare(strict_types=1);

namespace App\Controller;

use JulienLinard\Core\Controller\Controller;
use JulienLinard\Router\Attributes\Route;
use JulienLinard\Router\Response;
use JulienLinard\Core\Session\Session;
use App\Entity\Pizza;
use JulienLinard\Doctrine\EntityManager;
use App\Service\FileUploadService; // 1. On importe le service

class AdminPizzaController extends Controller
{
    private EntityManager $entityManager;
    private FileUploadService $fileUploader; // 2. Propriété pour le service

    // 3. On injecte le FileUploadService dans le constructeur
    public function __construct(EntityManager $entityManager, FileUploadService $fileUploader)
    {
        $this->entityManager = $entityManager;
        $this->fileUploader = $fileUploader;
    }

    #[Route(path: '/admin/pizzas/create', methods: ['GET'], name: 'admin_pizza_create')]
    public function create(): Response
    {
        return $this->view('admin/pizza_create', [
            'title' => 'Ajouter une nouvelle pizza'
        ]);
    }

    #[Route(path: '/admin/pizzas/create', methods: ['POST'], name: 'admin_pizza_store')]
    public function store(): Response
    {
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        
        // Validation basique
        if (empty($name)) {
            Session::flash('error', 'Le nom de la pizza est obligatoire');
            return $this->redirect('/admin/pizzas/create');
        }

        $pizza = new Pizza();
        $pizza->setName($name);
        $pizza->setDescription($description);

        // --- GESTION DE L'IMAGE ---
        // On vérifie si un fichier a été envoyé sans erreur
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            try {
                // On définit le dossier de destination (www/public/uploads/pizzas)
                // dirname(__DIR__, 2) remonte de 2 crans (de Controller vers src vers www)
                $uploadDir = dirname(__DIR__, 2) . '/public/uploads/pizzas';
                
                // On appelle notre service pour faire l'upload
                $filename = $this->fileUploader->upload($_FILES['image'], $uploadDir);
                
                // On sauvegarde le chemin relatif dans la base de données
                // Ex: "uploads/pizzas/pizza_654a...jpg"
                $pizza->setImageUrl('uploads/pizzas/' . $filename);
                
            } catch (\Exception $e) {
                // En cas d'erreur d'upload, on prévient l'utilisateur
                Session::flash('error', "Erreur lors de l'upload de l'image : " . $e->getMessage());
                return $this->redirect('/admin/pizzas/create');
            }
        } else {
            // Optionnel : Image par défaut si aucune image n'est envoyée
            $pizza->setImageUrl('https://placehold.co/600x400?text=Pas+d+image');
        }

        $this->entityManager->persist($pizza);
        $this->entityManager->flush();

        Session::flash('success', 'La pizza a été ajoutée avec succès !');

        return $this->redirect('/carte');
    }
}