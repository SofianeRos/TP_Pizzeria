<?php
use JulienLinard\Core\Session\Session;

$currentUser = Session::get('user');
?>

<div class="container mx-auto px-4 py-12">
    <div class="text-center mb-16">
        <h1 class="text-5xl font-bold text-gray-800 mb-4 font-logo">
            Notre Carte <span class="text-orange-600">Gourmande</span>
        </h1>
        <div class="w-24 h-1.5 bg-gradient-to-r from-orange-500 to-red-500 mx-auto rounded-full"></div>
        <p class="text-gray-500 mt-4 text-lg">Préparées avec amour et des ingrédients frais.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        <?php foreach ($pizzas as $pizza): ?>
            <div class="group bg-white rounded-3xl shadow-lg hover:shadow-2xl hover:shadow-orange-500/10 transition-all duration-300 flex flex-col h-full overflow-hidden border border-gray-100 hover:border-orange-200 hover:-translate-y-1">

                <div class="h-56 overflow-hidden bg-gray-100 relative">
                    <?php if ($pizza->getImageUrl()): ?>
                        <img src="<?= str_starts_with($pizza->getImageUrl(), 'http') ? $pizza->getImageUrl() : '/' . $pizza->getImageUrl() ?>"
                            alt="<?= htmlspecialchars($pizza->getName()) ?>"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-50">
                            <span class="text-5xl">🍕</span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($currentUser && isset($currentUser['role']) && $currentUser['role'] === 'GERANT'): ?>
                        <a href="/admin/pizzas/edit/<?= $pizza->getId() ?>"
                            class="absolute top-4 right-4 bg-white/90 backdrop-blur text-gray-600 hover:text-blue-600 p-2 rounded-full shadow-md transition-colors"
                            title="Modifier">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>

                <div class="p-8 flex-grow flex flex-col">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2 font-logo group-hover:text-orange-600 transition-colors">
                        <?= htmlspecialchars($pizza->getName()) ?>
                    </h3>

                    <p class="text-gray-600 text-sm mb-6 line-clamp-3 leading-relaxed flex-grow">
                        <?= htmlspecialchars($pizza->getDescription() ?? 'Aucune description') ?>
                    </p>

                    <div class="mt-auto pt-6 border-t border-gray-100">
                        <a href="/carte/<?= $pizza->getId() ?>" class="block w-full text-center bg-gray-50 hover:bg-gradient-to-r hover:from-orange-500 hover:to-red-600 text-gray-700 hover:text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-sm hover:shadow-lg">
                            Commander
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (empty($pizzas)): ?>
        <div class="text-center py-20 bg-white rounded-3xl shadow-sm border border-gray-100">
            <div class="text-7xl mb-6 opacity-50">🍽️</div>
            <p class="text-gray-500 text-xl mb-8 font-medium">Notre four chauffe encore... aucune pizza pour le moment.</p>

            <?php if ($currentUser && isset($currentUser['role']) && $currentUser['role'] === 'GERANT'): ?>
                <a href="/admin/pizzas/create" class="inline-block bg-orange-600 text-white px-8 py-3 rounded-xl hover:bg-orange-700 transition shadow-lg font-bold">
                    Ajouter une première pizza
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>