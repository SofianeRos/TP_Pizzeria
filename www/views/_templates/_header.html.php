<?php

use JulienLinard\Core\Session\Session;

// On récupère l'utilisateur connecté (ou null s'il n'y en a pas)
$user = Session::get('user');
$headerSuccess = Session::getFlash('success');
$headerError = Session::getFlash('error');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Pizzeria') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <nav class="bg-white shadow mb-8">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <a href="/" class="text-xl font-bold text-blue-600 flex items-center gap-2">
                    🍕 <span class="hidden sm:inline">Ma Pizzeria</span>
                </a>

                <div class="flex items-center gap-4">
                    <a href="/carte" class="text-gray-600 hover:text-blue-600 font-medium">La Carte</a>

                    <?php if ($user): ?>
                        <div class="hidden md:flex items-center gap-2 text-sm text-gray-500 border-l pl-4 ml-2">
                            <span class="font-semibold text-blue-600">
                                Bonjour, <?= htmlspecialchars($user['firstname'] ?? $user['email']) ?>
                            </span>
                        </div>

                        <?php if (isset($user['role']) && $user['role'] === 'GERANT'): ?>
                            <a href="/admin/pizzas/create" class="text-blue-600 font-bold hover:text-blue-800">
                                ⚙️ Admin
                            </a>
                        <?php endif; ?>

                        <a href="/logout" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm transition-colors shadow-sm">
                            Déconnexion
                        </a>
                    <?php else: ?>
                        <div class="flex items-center gap-2">
                            <a href="/login" class="text-gray-600 hover:text-blue-600 font-medium px-3 py-2">Connexion</a>
                            <a href="/register" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm transition-colors shadow-sm">
                                Inscription
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <?php if ($headerSuccess): ?>
        <div class="fixed top-20 right-4 z-50 max-w-md w-full animate-bounce-in">
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0">✅</div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800"><?= htmlspecialchars($headerSuccess) ?></p>
                    </div>
                </div>
            </div>
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('.bg-green-50')?.parentElement?.remove();
            }, 5000);
        </script>
    <?php endif; ?>

    <?php if ($headerError): ?>
        <div class="fixed top-20 right-4 z-50 max-w-md w-full animate-bounce-in">
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0">❌</div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800"><?= htmlspecialchars($headerError) ?></p>
                    </div>
                </div>
            </div>
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('.bg-red-50')?.parentElement?.remove();
            }, 5000);
        </script>
    <?php endif; ?>