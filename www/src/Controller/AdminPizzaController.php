<?php

declare(strict_types=1);

namespace App\Controller;

use JulienLinard\Core\Controller\Controller;
use JulienLinard\Router\Attributes\Route;
use JulienLinard\Router\Response;
use JulienLinard\Core\Session\Session;
use App\Entity\Pizza;
use App\Entity\PizzaPrice;
use App\Entity\Size; 
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

    // --- PAGE AJOUT ---
    #[Route(path: '/admin/pizzas/create', methods: ['GET'], name: 'admin_pizza_create')]
    public function create(): Response
    {
        $user = Session::get('user');
        if (!$user || $user['role'] !== 'GERANT') { return $this->redirect('/login'); }

        // 1. On récupère toutes les tailles disponibles
        $sizes = $this->entityManager->getRepository(Size::class)->findAll();

        return $this->view('admin/pizza_create', [
            'title' => 'Ajouter une nouvelle pizza',
            'sizes' => $sizes // On envoie les tailles à la vue
        ]);
    }

    // --- TRAITEMENT AJOUT ---
    #[Route(path: '/admin/pizzas/create', methods: ['POST'], name: 'admin_pizza_store')]
    public function store(): Response
    {
        $user = Session::get('user');
        if (!$user || $user['role'] !== 'GERANT') { return $this->redirect('/login'); }

        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        
        // Récupération du prix ET de la taille choisie
        $price = (float)($_POST['price'] ?? 0);
        $sizeId = (int)($_POST['size_id'] ?? 0);

        if (empty($name)) {
            Session::flash('error', 'Le nom est obligatoire');
            return $this->redirect('/admin/pizzas/create');
        }

        // Création de la Pizza
        $pizza = new Pizza();
        $pizza->setName($name);
        $pizza->setDescription($description);

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            try {
                $uploadDir = dirname(__DIR__, 2) . '/public/uploads/pizzas';
                $filename = $this->fileUploader->upload($_FILES['image'], $uploadDir);
                $pizza->setImageUrl('uploads/pizzas/' . $filename);
            } catch (\Exception $e) {}
        } else {
            $pizza->setImageUrl('https://placehold.co/600x400?text=Pizza');
        }

        $this->entityManager->persist($pizza);
        $this->entityManager->flush();

        // Sauvegarde du Prix pour la taille choisie
        if ($price > 0 && $sizeId > 0) {
            $this->savePrice($pizza->getId(), $sizeId, $price);
        }

        Session::flash('success', 'Pizza créée avec succès !');
        return $this->redirect('/carte');
    }

    // --- PAGE MODIFICATION ---
    #[Route(path: '/admin/pizzas/edit/{id}', methods: ['GET'], name: 'admin_pizza_edit')]
    public function edit(int $id): Response
    {
        $user = Session::get('user');
        if (!$user || $user['role'] !== 'GERANT') { return $this->redirect('/login'); }

        $pizza = $this->entityManager->getRepository(Pizza::class)->find($id);
        if (!$pizza) { return $this->redirect('/carte'); }

        // 1. Récupérer toutes les tailles
        $sizes = $this->entityManager->getRepository(Size::class)->findAll();

        // 2. Récupérer les prix ACTUELS de cette pizza (pour les afficher)
        // On fait une petite requête SQL pour avoir un tableau propre [Taille => Prix]
        $currentPrices = [];
        try {
            $pdo = $this->getPdo();
            $stmt = $pdo->prepare("
                SELECT p.price, s.label 
                FROM pizza_prices p 
                JOIN sizes s ON p.size_id = s.id 
                WHERE p.pizza_id = :id
            ");
            $stmt->execute([':id' => $id]);
            $currentPrices = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {}

        return $this->view('admin/pizza_edit', [
            'title' => 'Modifier ' . $pizza->getName(),
            'pizza' => $pizza,
            'sizes' => $sizes,
            'currentPrices' => $currentPrices
        ]);
    }

    // --- TRAITEMENT MODIFICATION ---
    #[Route(path: '/admin/pizzas/edit/{id}', methods: ['POST'], name: 'admin_pizza_update')]
    public function update(int $id): Response
    {
        $user = Session::get('user');
        if (!$user || $user['role'] !== 'GERANT') { return $this->redirect('/login'); }

        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        
        // Récupération prix et taille
        $price = (float)($_POST['price'] ?? 0);
        $sizeId = (int)($_POST['size_id'] ?? 0);

        // Mise à jour Pizza (Nom/Description)
        $this->updatePizzaSql($id, $name, $description);

        // Mise à jour Image
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            try {
                $uploadDir = dirname(__DIR__, 2) . '/public/uploads/pizzas';
                $filename = $this->fileUploader->upload($_FILES['image'], $uploadDir);
                $this->updateImageSql($id, 'uploads/pizzas/' . $filename);
            } catch (\Exception $e) {}
        }

        // Mise à jour PRIX (Si une taille et un prix sont fournis)
        if ($price > 0 && $sizeId > 0) {
            $this->savePrice($id, $sizeId, $price);
            Session::flash('success', 'Prix mis à jour pour cette taille !');
        } else {
            Session::flash('success', 'Informations modifiées.');
        }

        // On reste sur la page d'édition pour pouvoir ajouter d'autres prix si besoin
        return $this->redirect('/admin/pizzas/edit/' . $id);
    }

    #[Route(path: '/admin/pizzas/delete/{id}', methods: ['POST'], name: 'admin_pizza_delete')]
    public function delete(int $id): Response
    {
        $user = Session::get('user');
        if (!$user || $user['role'] !== 'GERANT') { return $this->redirect('/login'); }

        try {
            $pdo = $this->getPdo();
            $pdo->prepare("DELETE FROM pizza_prices WHERE pizza_id = :id")->execute([':id' => $id]);
            $pdo->prepare("DELETE FROM pizzas WHERE id = :id")->execute([':id' => $id]);
            Session::flash('success', 'Pizza supprimée.');
        } catch (\Exception $e) {
            Session::flash('error', 'Erreur suppression.');
        }
        return $this->redirect('/carte');
    }

    // --- Helpers SQL ---
    private function getPdo(): \PDO {
        return new \PDO(
            'mysql:host=' . getenv('MARIADB_CONTAINER') . ';dbname=' . getenv('MYSQL_DATABASE') . ';charset=utf8mb4',
            getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'), [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
        );
    }

    private function savePrice(int $pizzaId, int $sizeId, float $price) {
        $pdo = $this->getPdo();
        // Vérifier si le prix existe déjà pour cette taille
        $stmt = $pdo->prepare("SELECT id FROM pizza_prices WHERE pizza_id = :pid AND size_id = :sid");
        $stmt->execute([':pid' => $pizzaId, ':sid' => $sizeId]);
        
        if ($stmt->fetch()) {
            $sql = "UPDATE pizza_prices SET price = :price WHERE pizza_id = :pid AND size_id = :sid";
        } else {
            $sql = "INSERT INTO pizza_prices (pizza_id, size_id, price) VALUES (:pid, :sid, :price)";
        }
        $pdo->prepare($sql)->execute([':pid' => $pizzaId, ':sid' => $sizeId, ':price' => $price]);
    }

    private function updatePizzaSql($id, $name, $description) {
        $this->getPdo()->prepare("UPDATE pizzas SET name = :name, description = :desc WHERE id = :id")
             ->execute([':name' => $name, ':desc' => $description, ':id' => $id]);
    }

    private function updateImageSql($id, $url) {
        $this->getPdo()->prepare("UPDATE pizzas SET image_url = :url WHERE id = :id")
             ->execute([':url' => $url, ':id' => $id]);
    }
}