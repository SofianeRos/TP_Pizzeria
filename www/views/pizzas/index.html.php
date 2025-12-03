<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-center text-gray-800 mb-12">🍕 Notre Carte</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($pizzas as $pizza): ?>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="h-48 overflow-hidden bg-gray-200">
                    <?php if ($pizza->getImageUrl()): ?>
                        <img src="<?= str_starts_with($pizza->getImageUrl(), 'http') ? $pizza->getImageUrl() : '/' . $pizza->getImageUrl() ?>" 
                             alt="<?= htmlspecialchars($pizza->getName()) ?>" 
                             class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-500">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            Pas d'image
                        </div>
                    <?php endif; ?>
                </div>

                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($pizza->getName()) ?></h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                        <?= htmlspecialchars($pizza->getDescription() ?? 'Aucune description') ?>
                    </p>
                    
                    <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-100">
                        <span class="text-sm text-gray-500">À partir de</span>
                        <span class="text-lg font-bold text-blue-600">-- €</span>
                    </div>
                    
                    <a href="/carte/<?= $pizza->getId() ?>" class="mt-4 block w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-2 px-4 rounded-lg transition-colors">
                        Voir les détails
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (empty($pizzas)): ?>
        <div class="text-center py-12">
            <p class="text-gray-500 text-lg">Aucune pizza n'est disponible pour le moment.</p>
            <a href="/admin/pizzas/create" class="text-blue-600 hover:underline mt-2 inline-block">Ajouter une pizza (Admin)</a>
        </div>
    <?php endif; ?>
</div>