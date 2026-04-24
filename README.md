
# TP Pizzeria 🍕

Une application web complète de commande de pizzas développée en PHP 8. Ce projet utilise une architecture MVC sur mesure basée sur un framework pédagogique personnalisé, avec une approche moderne (Injection de dépendances, Attributs de routage, ORM "maison").

## 📋 Fonctionnalités

### Côté Client

- **Catalogue :** Consultation des pizzas disponibles, de leurs tailles et de leurs prix.
- **Panier :** Ajout, modification et suppression d'articles via un service dédié (`CartService`).
- **Commande :** Processus de validation de commande avec informations de livraison.
- **Espace personnel :** Historique des commandes et suivi de l'état d'avancement.

### Côté Administration (Rôle `GERANT`)

- **Gestion du catalogue :**
  - Création, modification et suppression de pizzas.
  - Upload sécurisé d'images (`FileUploadService`).
  - Gestion des déclinaisons de prix selon les tailles.
- **Gestion des commandes :**
  - Tableau de bord listant toutes les commandes entrantes.
  - Modification en temps réel du statut de la commande (_En attente, En préparation, En livraison, Livrée, Annulée_).

## 🚀 Technologies utilisées

- **Backend :** PHP 8 (Typage strict, Attributs `#[Route]`)
- **Architecture :** MVC, Singleton, Injection de dépendances (Container DI), Events Dispatcher
- **Base de données :** MariaDB / MySQL avec un micro-ORM basé sur Doctrine (`EntityManager`, `Repository`)
- **Frontend :** HTML/PHP Templates stylisés avec **Tailwind CSS**
- **Infrastructure :** Docker / Docker Compose

## 📁 Structure du Projet

```text
www/
├── config/          # Fichiers de configuration centralisés (database.php, etc.)
├── public/          # Point d'entrée web
│   ├── index.php    # Bootstrap de l'application
│   └── uploads/     # Images des pizzas (nécessite des permissions d'écriture)
├── src/             # Code source métier de l'application
│   ├── Controller/  # Contrôleurs gérant les requêtes HTTP
│   ├── Entity/      # Modèles de données (User, Pizza, Order, etc.)
│   └── Service/     # Logique métier encapsulée (Panier, Uploads, Events)
├── storage/logs/    # Fichiers de journaux d'erreurs
└── views/           # Fichiers de templates pour l'affichage (HTML/PHP)
```

## 🛠️ Installation & Configuration

### 1. Prérequis

- Docker et Docker Compose installés.
- PHP 8.x et Composer (si exécution en local hors Docker).

### 2. Variables d'environnement

L'application exige un fichier de configuration d'environnement pour fonctionner et sécuriser les identifiants de la base de données.

1. Copiez le fichier d'exemple : `cp .env.example .env` (à la racine du dossier `www/`)
2. Configurez les accès à la base de données (ces variables sont requises par `config/database.php`) :
   ```env
   MYSQL_DATABASE=pizzeria
   MYSQL_USER=user
   MYSQL_PASSWORD=secret
   MARIADB_CONTAINER=mariadb_app
   ```

### 3. Permissions des dossiers (Environnement Docker/Linux)

Certains dossiers (`storage/logs` et `public/uploads`) nécessitent des droits d'écriture pour que l'application puisse enregistrer les logs et télécharger les images des pizzas.

Un script de correction des permissions est fourni :

```bash
# Sur l'hôte :
./fix-permissions.sh

# Ou directement dans le container :
docker compose exec apache_app bash fix-permissions.sh
```

### 4. Démarrer l'application

Une fois l'environnement configuré, vous pouvez accéder à l'application via le port exposé par votre serveur web / container Docker (ex: `http://localhost:8080`).

## 🔐 Sécurité intégrée

- **Gestion de session stricte :** Configurations HTTP-Only / SameSite configurées à l'amorçage.
- **Environnements configurables :** Les logs d'erreur ne sont affichés qu'en mode `DEBUG=true`.
- **Protection XSS & SQL :** L'ORM utilise des requêtes préparées via PDO, et les entités protègent contre les injections de masse.

---

_Projet développé dans un cadre d'apprentissage et de bonnes pratiques de l'architecture PHP moderne._
