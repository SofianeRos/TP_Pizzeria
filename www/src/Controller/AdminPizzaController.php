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
     * Affiche le formulaire d'ajout
     */
    #[Route(path: '/admin/pizzas/create', methods: ['GET'], name: 'admin_pizza_create')]
    public function create(): Response
    {
        $user = Session::get('user');
        if (!$user || $user['role'] !== 'GERANT') {
            Session::flash('error', 'Accès interdit.');
            return $this->redirect('/login');
        }

        // ✅ CORRECTION CHEMIN : admin/pizza_create (sans sous-dossier)
        return $this->view('admin/pizza_create', [
            'title' => 'Ajouter une nouvelle pizza'
        ]);
    }

    /**
     * Traite l'ajout
     */
    #[Route(path: '/admin/pizzas/create', methods: ['POST'], name: 'admin_pizza_store')]
    public function store(): Response
    {
        $user = Session::get('user');
        if (!$user || $user['role'] !== 'GERANT') {
            return $this->redirect('/login');
        }

        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        
        if (empty($name)) {
            Session::flash('error', 'Le nom de la pizza est obligatoire');
            return $this->redirect('/admin/pizzas/create');
        }

        $pizza = new Pizza();
        $pizza->setName($name);
        $pizza->setDescription($description);

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            try {
                $uploadDir = dirname(__DIR__, 2) . '/public/uploads/pizzas';
                $filename = $this->fileUploader->upload($_FILES['image'], $uploadDir);
                $pizza->setImageUrl('uploads/pizzas/' . $filename);
            } catch (\Exception $e) {
                Session::flash('error', "Erreur image : " . $e->getMessage());
                return $this->redirect('/admin/pizzas/create');
            }
        } else {
            $pizza->setImageUrl('https://placehold.co/600x400?text=Pas+d+image');
        }

        $this->entityManager->persist($pizza);
        $this->entityManager->flush();

        Session::flash('success', 'La pizza a été ajoutée avec succès !');
        return $this->redirect('/carte');
    }

    /**
     * Affiche le formulaire de modification
     */
    #[Route(path: '/admin/pizzas/edit/{id}', methods: ['GET'], name: 'admin_pizza_edit')]
    public function edit(int $id): Response
    {
        $user = Session::get('user');
        if (!$user || $user['role'] !== 'GERANT') {
            Session::flash('error', 'Accès interdit.');
            return $this->redirect('/login');
        }

        $pizza = $this->entityManager->getRepository(Pizza::class)->find($id);

        if (!$pizza) {
            Session::flash('error', 'Pizza introuvable.');
            return $this->redirect('/carte');
        }

        // ✅ CORRECTION CHEMIN : admin/pizza_edit (sans sous-dossier)
        return $this->view('admin/pizza_edit', [
            'title' => 'Modifier ' . $pizza->getName(),
            'pizza' => $pizza
        ]);
    }

    /**
     * Traite la modification (Update)
     */
    #[Route(path: '/admin/pizzas/edit/{id}', methods: ['POST'], name: 'admin_pizza_update')]
    public function update(int $id): Response
    {
        $user = Session::get('user');
        if (!$user || $user['role'] !== 'GERANT') {
            return $this->redirect('/login');
        }

        $pizza = $this->entityManager->getRepository(Pizza::class)->find($id);
        if (!$pizza) {
            return $this->redirect('/carte');
        }

        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';

        if (!empty($name)) $pizza->setName($name);
        $pizza->setDescription($description);

        $imageHasChanged = false;
        $newImageUrl = '';

        // Gestion de l'Image
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            try {
                $uploadDir = dirname(__DIR__, 2) . '/public/uploads/pizzas';
                $filename = $this->fileUploader->upload($_FILES['image'], $uploadDir);
                $newImageUrl = 'uploads/pizzas/' . $filename;
                
                $pizza->setImageUrl($newImageUrl);
                $imageHasChanged = true;

            } catch (\Exception $e) {
                Session::flash('error', "Erreur image : " . $e->getMessage());
                return $this->redirect('/admin/pizzas/edit/' . $id);
            }
        }

        // Sauvegarde ORM
        $this->entityManager->persist($pizza);
        $this->entityManager->flush();

        // Sauvegarde Force Brute SQL (Si l'image a changé)
        if ($imageHasChanged) {
            try {
                $dsn = 'mysql:host=' . getenv('MARIADB_CONTAINER') . ';dbname=' . getenv('MYSQL_DATABASE') . ';charset=utf8mb4';
                $pdo = new \PDO($dsn, getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'));
                $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                
                $sql = "UPDATE pizzas SET image_url = :img WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':img' => $newImageUrl,
                    ':id' => $id
                ]);
            } catch (\Exception $e) {
                // On ignore silencieusement si le fallback échoue
            }
        }

        Session::flash('success', 'Pizza modifiée avec succès !');
        return $this->redirect('/carte');
    }
}