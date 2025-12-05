<?php

use JulienLinard\Core\Session\Session;

$currentUser = Session::get('user');
?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-center text-gray-800 mb-12">🍕 Notre Carte</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($pizzas as $pizza): ?>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col h-full">

                <div class="h-48 overflow-hidden bg-gray-200 relative group">
                    <?php if ($pizza->getImageUrl()): ?>
                        <img src="<?= str_starts_with($pizza->getImageUrl(), 'http') ? $pizza->getImageUrl() : '/' . $pizza->getImageUrl() ?>"
                            alt="<?= htmlspecialchars($pizza->getName()) ?>"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-100">
                            <span class="text-3xl">🍕</span>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="p-6 flex-grow flex flex-col">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-xl font-bold text-gray-800"><?= htmlspecialchars($pizza->getName()) ?></h3>

                        <?php if ($currentUser && isset($currentUser['role']) && $currentUser['role'] === 'GERANT'): ?>
                            <a href="/admin/pizzas/edit/<?= $pizza->getId() ?>"
                                class="text-gray-400 hover:text-blue-600 p-1 hover:bg-blue-50 rounded transition-colors"
                                title="Modifier cette pizza">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 21h8m.174-14.188a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                </svg> </a>
                        <?php endif; ?>
                    </div>

                    <p class="text-gray-600 text-sm mb-4 line-clamp-3 flex-grow">
                        <?= htmlspecialchars($pizza->getDescription() ?? 'Aucune description') ?>
                    </p>

                    <div class="mt-auto pt-4 border-t border-gray-100">
                        <a href="/carte/<?= $pizza->getId() ?>" class="block w-full text-center bg-gray-100 hover:bg-blue-600 hover:text-white text-gray-800 font-semibold py-2 px-4 rounded-lg transition-all duration-300">
                            Commander
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (empty($pizzas)): ?>
        <div class="text-center py-16 bg-gray-50 rounded-lg">
            <div class="text-6xl mb-4">🍽️</div>
            <p class="text-gray-500 text-lg mb-4">Aucune pizza n'est disponible pour le moment.</p>

            <?php if ($currentUser && isset($currentUser['role']) && $currentUser['role'] === 'GERANT'): ?>
                <a href="/admin/pizzas/create" class="inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition-colors">
                    Ajouter une première pizza
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>