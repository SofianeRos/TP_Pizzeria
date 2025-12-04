<?php

declare(strict_types=1);

namespace App\Controller;

use JulienLinard\Core\Controller\Controller;
use JulienLinard\Router\Attributes\Route;
use JulienLinard\Router\Response;
use JulienLinard\Core\Session\Session;
use App\Entity\Pizza;
use JulienLinard\Doctrine\EntityManager;
use App\Service\FileUploadService;

class AdminPizzaController extends Controller
{
    private EntityManager $entityManager;
    private FileUploadService $fileUploader;

    public function __construct(EntityManager $entityManager, FileUploadService $fileUploader)
    {
        $this->entityManager = $entityManager;
        $this->fileUploader = $fileUploader;
    }

    /**
     * Affiche le formulaire d'ajout (PROTÉGÉ)
     */
    #[Route(path: '/admin/pizzas/create', methods: ['GET'], name: 'admin_pizza_create')]
    public function create(): Response
    {
        // 👇 SÉCURITÉ : Vérification du rôle
        $user = Session::get('user');
        
        // Si l'utilisateur n'est pas connecté OU n'est pas gérant -> Redirection
        if (!$user || $user['role'] !== 'GERANT') {
            Session::flash('error', 'Accès interdit : espace réservé aux gérants.');
            return $this->redirect('/login');
        }
        // 👆 FIN SÉCURITÉ

        return $this->view('admin/pizza_create', [
            'title' => 'Ajouter une nouvelle pizza'
        ]);
    }

    /**
     * Traite l'ajout de la pizza (PROTÉGÉ)
     */
    #[Route(path: '/admin/pizzas/create', methods: ['POST'], name: 'admin_pizza_store')]
    public function store(): Response
    {
        // 👇 SÉCURITÉ : On revérifie aussi lors de la soumission du formulaire
        $user = Session::get('user');
        if (!$user || $user['role'] !== 'GERANT') {
            Session::flash('error', 'Vous n\'avez pas les droits pour effectuer cette action.');
            return $this->redirect('/login');
        }

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
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            try {
                $uploadDir = dirname(__DIR__, 2) . '/public/uploads/pizzas';
                $filename = $this->fileUploader->upload($_FILES['image'], $uploadDir);
                
                // Chemin relatif pour la BDD
                $pizza->setImageUrl('uploads/pizzas/' . $filename);
                
            } catch (\Exception $e) {
                Session::flash('error', "Erreur lors de l'upload : " . $e->getMessage());
                return $this->redirect('/admin/pizzas/create');
            }
        } else {
            // Image par défaut
            $pizza->setImageUrl('https://placehold.co/600x400?text=Pas+d+image');
        }

        // Sauvegarde
        $this->entityManager->persist($pizza);
        $this->entityManager->flush();

        Session::flash('success', 'La pizza a été ajoutée avec succès !');

        return $this->redirect('/carte');
    }
}