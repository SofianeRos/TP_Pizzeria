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
     * Traite l'inscription (C'est ICI que ça se joue)
     */
    #[Route(path: '/register', methods: ['POST'], name: 'auth_register_post')]
    public function store(): Response
    {
        // 👇 1. Récupération des champs du formulaire
        $firstname = $_POST['firstname'] ?? '';
        $lastname = $_POST['lastname'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';

        // Validation
        if (empty($firstname) || empty($lastname) || empty($email) || empty($password)) {
            Session::flash('error', 'Tous les champs sont obligatoires');
            return $this->redirect('/register');
        }

        // Au moins 8 chars, 1 Lettre, 1 Chiffre, 1 Spécial
        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
            Session::flash('error', 'Le mot de passe doit faire 8 caractères min avec 1 lettre, 1 chiffre et 1 caractère spécial.');
            return $this->redirect('/register');
        }
        if ($password !== $passwordConfirm) {
            Session::flash('error', 'Les mots de passe ne correspondent pas');
            return $this->redirect('/register');
        }

        // Vérification email unique
        $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
        if ($existingUser) {
            Session::flash('error', 'Cet email est déjà utilisé');
            return $this->redirect('/register');
        }

        // Création de l'utilisateur
        $user = new User();

        // 👇 2. Enregistrement des données dans l'objet (Indispensable !)
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        // 👆 Si ces deux lignes manquent, le nom sera vide en base de données

        $user->setEmail($email);
        $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
        $user->setRole('CLIENT');

        // Sauvegarde en base de données
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        Session::flash('success', 'Compte créé ! Bienvenue ' . $firstname);
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
     * Traite la connexion
     */
    #[Route(path: '/login', methods: ['POST'], name: 'auth_login_post')]
    public function authenticate(): Response
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        if (!$user || !password_verify($password, $user->getPassword())) {
            Session::flash('error', 'Identifiants incorrects');
            return $this->redirect('/login');
        }

        // 👇 3. Mise en session des infos complètes
        Session::set('user', [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'firstname' => $user->getFirstname(), // Important pour l'affichage "Bonjour Prénom"
            'lastname' => $user->getLastname(),
            'role' => $user->getRole()
        ]);

        Session::flash('success', "Ravi de vous revoir " . $user->getFirstname() . " !");

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
        Session::remove('user');
        Session::flash('success', 'Vous êtes déconnecté.');
        return $this->redirect('/');
    }
}
