<?php
use JulienLinard\Core\Session\Session;

// On récupère l'utilisateur connecté (ou null s'il n'y en a pas)
$user = Session::get('user');
$headerSuccess = Session::getFlash('success');
$headerError = Session::getFlash('error');

// On récupère le panier pour afficher le nombre d'articles (Petit bonus UX)
$cart = Session::get('cart', []);
$cartCount = 0;
foreach($cart as $item) {
    $cartCount += $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Ma Pizzeria') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <nav class="bg-white shadow sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                
                <a href="/" class="text-2xl font-bold text-blue-600 flex items-center gap-2 hover:text-blue-700 transition">
                    🍕 <span class="hidden sm:inline">Ma Pizzeria</span>
                </a>

                <div class="flex items-center gap-6">
                    
                    <a href="/carte" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">
                        La Carte
                    </a>

                    <a href="/panier" class="relative text-gray-600 hover:text-blue-600 font-medium transition-colors flex items-center gap-1">
                        🛒 <span class="hidden sm:inline">Panier</span>
                        <?php if ($cartCount > 0): ?>
                            <span class="absolute -top-2 -right-3 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center animate-bounce">
                                <?= $cartCount ?>
                            </span>
                        <?php endif; ?>
                    </a>
                    
                    <?php if ($user): ?>
                        <div class="hidden lg:flex items-center gap-2 text-sm text-gray-500 border-l border-gray-300 pl-4 ml-2">
                            <span class="font-semibold text-blue-600">
                                Bonjour, <?= htmlspecialchars($user['firstname'] ?? $user['email']) ?>
                            </span>
                        </div>
                        
                        <a href="/mes-commandes" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">
                            📜 <span class="hidden md:inline">Mes Commandes</span>
                        </a>
                        
                        <?php if (isset($user['role']) && $user['role'] === 'GERANT'): ?>
                            <a href="/admin/pizzas/create" class="text-purple-600 font-bold hover:text-purple-800 transition-colors bg-purple-50 px-3 py-1 rounded-md">
                                ⚙️ Admin
                            </a>
                            <a href="/admin/orders" class="text-purple-600 font-bold hover:text-purple-800 transition-colors bg-purple-50 px-3 py-1 rounded-md ml-2">
                                👨‍🍳 Commandes
                            </a>
                            <?php endif; ?>
                        
                        <a href="/logout" class="bg-red-50 text-red-600 hover:bg-red-500 hover:text-white border border-red-200 px-4 py-2 rounded-md text-sm transition-all shadow-sm">
                            Déconnexion
                        </a>
                    <?php else: ?>
                        <div class="flex items-center gap-3 border-l border-gray-300 pl-4">
                            <a href="/login" class="text-gray-600 hover:text-blue-600 font-medium">Connexion</a>
                            <a href="/register" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm transition-colors shadow-sm font-medium">
                                Inscription
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <?php if ($headerSuccess): ?>
    <div class="fixed top-20 right-4 z-50 max-w-md w-full animate-[slideIn_0.5s_ease-out]">
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-xl flex items-center">
            <div class="flex-shrink-0 text-2xl mr-3">✅</div>
            <div>
                <p class="text-sm font-bold text-green-800">Succès</p>
                <p class="text-sm text-green-700"><?= htmlspecialchars($headerSuccess) ?></p>
            </div>
        </div>
    </div>
    <script>setTimeout(() => { document.querySelector('.bg-green-50')?.parentElement?.remove(); }, 5000);</script>
    <?php endif; ?>
    
    <?php if ($headerError): ?>
    <div class="fixed top-20 right-4 z-50 max-w-md w-full animate-[slideIn_0.5s_ease-out]">
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-xl flex items-center">
            <div class="flex-shrink-0 text-2xl mr-3">❌</div>
            <div>
                <p class="text-sm font-bold text-red-800">Erreur</p>
                <p class="text-sm text-red-700"><?= htmlspecialchars($headerError) ?></p>
            </div>
        </div>
    </div>
    <script>setTimeout(() => { document.querySelector('.bg-red-50')?.parentElement?.remove(); }, 5000);</script>
    <?php endif; ?>

    <main class="flex-grow">