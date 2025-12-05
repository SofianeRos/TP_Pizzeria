<div class="container mx-auto px-4 py-8">
    
    <a href="/carte" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-6 transition-colors font-medium">
        &larr; Retour à la carte
    </a>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col md:flex-row">
        
        <div class="md:w-1/2 h-64 md:h-auto relative bg-gray-100">
            <?php if ($pizza->getImageUrl()): ?>
                <img class="absolute inset-0 w-full h-full object-cover" 
                     src="<?= str_starts_with($pizza->getImageUrl(), 'http') ? $pizza->getImageUrl() : '/' . $pizza->getImageUrl() ?>" 
                     alt="<?= htmlspecialchars($pizza->getName()) ?>">
            <?php else: ?>
                <div class="flex items-center justify-center h-full text-gray-400">
                    <span>Pas d'image disponible</span>
                </div>
            <?php endif; ?>
        </div>

        <div class="md:w-1/2 p-8 md:p-12">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4"><?= htmlspecialchars($pizza->getName()) ?></h1>
            
            <div class="prose text-gray-600 mb-8">
                <h3 class="text-sm font-bold uppercase tracking-wide text-gray-400 mb-2">Ingrédients</h3>
                <p><?= nl2br(htmlspecialchars($pizza->getDescription() ?? 'Aucune description.')) ?></p>
            </div>

            <?php if (empty($options)): ?>
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                    <p class="text-yellow-700">⚠️ Cette pizza n'est pas disponible (prix non configurés).</p>
                </div>
            <?php else: ?>
                <form action="/panier/add" method="POST" class="bg-gray-50 rounded-xl p-6 border border-gray-100">
                    <input type="hidden" name="pizza_id" value="<?= $pizza->getId() ?>">
                    
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-3">Choisir la taille :</label>
                        <div class="space-y-2">
                            <?php foreach ($options as $index => $option): ?>
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer bg-white hover:border-blue-400 transition-colors has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50 has-[:checked]:ring-1 has-[:checked]:ring-blue-600">
                                    <input type="radio" name="size_id" value="<?= $option['size_id'] ?>" 
                                           class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                           <?= $index === 0 ? 'checked' : '' ?>>
                                    <div class="ml-3 flex justify-between w-full">
                                        <span class="font-medium text-gray-900"><?= htmlspecialchars($option['label']) ?></span>
                                        <span class="font-bold text-blue-600"><?= number_format($option['price'], 2) ?> €</span>
                                    </div>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="quantity" class="block text-sm font-bold text-gray-700 mb-2">Quantité :</label>
                        <select name="quantity" id="quantity" class="w-24 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <?php for($i=1; $i<=10; $i++): ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700 transition duration-300 shadow-lg flex justify-center gap-2 items-center">
                        <span>Ajouter au panier</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>