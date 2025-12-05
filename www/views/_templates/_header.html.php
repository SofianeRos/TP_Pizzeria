<?php
use JulienLinard\Core\Session\Session;

// On récupère l'utilisateur connecté
$user = Session::get('user');
$headerSuccess = Session::getFlash('success');
$headerError = Session::getFlash('error');

// Calcul du panier
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
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .font-logo { font-family: 'Lobster', cursive; }
    </style>
</head>

<body class="bg-gradient-to-br from-orange-100 via-white to-yellow-50 min-h-screen flex flex-col text-gray-800">

    <nav class="bg-white shadow-md sticky top-0 z-50 border-b-4 border-orange-500">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-20">
                
                <a href="/" class="flex items-center gap-3 group">
                    <div class="bg-orange-100 p-2 rounded-full group-hover:rotate-12 transition-transform duration-300">
                        <span class="text-3xl">🍕</span>
                    </div>
                    <span class="font-logo text-3xl text-orange-600 group-hover:text-orange-700 transition-colors">
                        Le Roi Des Pizza
                    </span>
                </a>

                <div class="flex items-center gap-4">

                    <a href="/carte" class="hidden md:flex items-center gap-2 font-bold text-gray-600 hover:text-orange-600 px-4 py-2 rounded-lg hover:bg-orange-50 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        La Carte
                    </a>

                    <a href="/panier" class="relative flex items-center gap-2 bg-gray-100 hover:bg-orange-500 hover:text-white text-gray-700 px-4 py-2 rounded-full font-bold transition-all duration-300 group shadow-sm border border-gray-200 hover:border-orange-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="hidden sm:inline">Panier</span>
                        
                        <?php if ($cartCount > 0): ?>
                            <span class="bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded-full shadow-sm group-hover:bg-white group-hover:text-red-600 transition-colors">
                                <?= $cartCount ?>
                            </span>
                        <?php endif; ?>
                    </a>

                    <div class="h-8 w-px bg-gray-300 mx-1"></div>

                    <?php if ($user): ?>
                        
                        <?php if (isset($user['role']) && $user['role'] === 'GERANT'): ?>
                            <a href="/admin/orders" class="flex flex-col items-center justify-center text-purple-600 hover:bg-purple-50 p-2 rounded-lg transition" title="Administration">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="text-[10px] font-bold uppercase hidden md:inline">Admin</span>
                            </a>
                        <?php endif; ?>

                        <div class="flex items-center gap-2">
                            <a href="/mes-commandes" class="flex flex-col items-center justify-center text-blue-600 hover:bg-blue-50 p-2 rounded-lg transition" title="Mes Commandes">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                                <span class="text-[10px] font-bold uppercase hidden md:inline">Commandes</span>
                            </a>

                            <a href="/logout" class="flex flex-col items-center justify-center text-red-500 hover:bg-red-50 p-2 rounded-lg transition" title="Se déconnecter">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span class="text-[10px] font-bold uppercase hidden md:inline">Sortir</span>
                            </a>
                        </div>
                    
                    <?php else: ?>
                        <div class="flex gap-3">
                            <a href="/login" class="text-gray-600 font-bold hover:text-orange-600 px-3 py-2 transition hidden sm:block">
                                Connexion
                            </a>
                            <a href="/register" class="bg-orange-600 text-white px-5 py-2 rounded-lg font-bold hover:bg-orange-700 shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                                Inscription
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <?php if ($headerSuccess): ?>
    <div class="fixed top-24 right-4 z-[99] animate-[slideIn_0.5s_ease-out]">
        <div class="bg-white border-l-4 border-green-500 p-4 rounded-lg shadow-2xl flex items-center gap-4 max-w-sm">
            <div class="bg-green-100 p-2 rounded-full text-green-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div>
                <p class="font-bold text-gray-800">Succès</p>
                <p class="text-sm text-gray-600"><?= htmlspecialchars($headerSuccess) ?></p>
            </div>
        </div>
    </div>
    <script>setTimeout(() => { document.querySelector('.fixed.top-24')?.remove(); }, 4000);</script>
    <?php endif; ?>
    
    <?php if ($headerError): ?>
    <div class="fixed top-24 right-4 z-[99] animate-[slideIn_0.5s_ease-out]">
        <div class="bg-white border-l-4 border-red-500 p-4 rounded-lg shadow-2xl flex items-center gap-4 max-w-sm">
             <div class="bg-red-100 p-2 rounded-full text-red-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="font-bold text-gray-800">Attention</p>
                <p class="text-sm text-gray-600"><?= htmlspecialchars($headerError) ?></p>
            </div>
        </div>
    </div>
    <script>setTimeout(() => { document.querySelector('.fixed.top-24')?.remove(); }, 5000);</script>
    <?php endif; ?>

    <main class="flex-grow">