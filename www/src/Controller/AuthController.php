<?php

declare(strict_types=1);

namespace App\Controller;

use JulienLinard\Core\Controller\Controller;
use JulienLinard\Router\Attributes\Route;
use JulienLinard\Router\Response;
use JulienLinard\Core\Session\Session;
use App\Entity\User;
use JulienLinard\Doctrine\EntityManager;

class AuthController extends Controller
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Affiche le formulaire d'inscription
     */
    #[Route(path: '/register', methods: ['GET'], name: 'auth_register')]
    public function register(): Response
    {
        return $this->view('auth/register', [
            'title' => 'Inscription'
        ]);
    }

    /**
     * Traite l'inscription
     */
    #[Route(path: '/register', methods: ['POST'], name: 'auth_register_post')]
    public function store(): Response
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';

        // 1. Validations de base
        if (empty($email) || empty($password)) {
            Session::flash('error', 'Tous les champs sont obligatoires');
            return $this->redirect('/register');
        }

        if ($password !== $passwordConfirm) {
            Session::flash('error', 'Les mots de passe ne correspondent pas');
            return $this->redirect('/register');
        }

        // Vérifie : 8 caractères min, au moins 1 lettre et 1 chiffre
        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $password)) {
            Session::flash('error', 'Le mot de passe doit faire 8 caractères minimum et contenir au moins 1 lettre et 1 chiffre.');
            return $this->redirect('/register');
        }
        // 2. Vérifier si l'email existe déjà
        $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
        if ($existingUser) {
            Session::flash('error', 'Cet email est déjà utilisé');
            return $this->redirect('/register');
        }

        // 3. Créer l'utilisateur
        $user = new User();
        $user->setEmail($email);
        // Hachage du mot de passe 
        $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
        $user->setRole('CLIENT'); // Rôle par défaut

        // 4. Sauvegarder
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        Session::flash('success', 'Votre compte a été créé ! Connectez-vous.');
        return $this->redirect('/login');
    }
    
    /**
     * Affiche le formulaire de connexion 
     */
    #[Route(path: '/login', methods: ['GET'], name: 'auth_login')]
    public function login(): Response
    {
        return $this->view('auth/login', [
            'title' => 'Connexion'
        ]);
    }
    /**
     * Traite la connexion (POST)
     */
    #[Route(path: '/login', methods: ['POST'], name: 'auth_login_post')]
    public function authenticate(): Response
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // 1. Chercher l'utilisateur par son email
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        // 2. Vérifier si l'utilisateur existe ET si le mot de passe est bon
        if (!$user || !password_verify($password, $user->getPassword())) {
            // Sécurité : On met un message vague pour ne pas dire si c'est l'email ou le mdp qui est faux
            Session::flash('error', 'Identifiants incorrects');
            return $this->redirect('/login');
        }

        // 3. Connexion réussie : On stocke les infos en session
        Session::set('user', [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'role' => $user->getRole()
        ]);

        Session::flash('success', "Bienvenue " . $user->getEmail() . " !");
        
        // Redirection intelligente : Si c'est un gérant, vers l'admin, sinon l'accueil
        if ($user->getRole() === 'GERANT') {
            return $this->redirect('/admin/pizzas/create');
        }

        return $this->redirect('/carte');
    }

    /**
     * Déconnexion
     */
    #[Route(path: '/logout', methods: ['GET'], name: 'auth_logout')]
    public function logout(): Response
    {
        // On détruit la session
        Session::remove('user');
        Session::flash('success', 'Vous êtes déconnecté.');
        
        return $this->redirect('/');
    }
}