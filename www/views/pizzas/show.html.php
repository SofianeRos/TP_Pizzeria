<div class="container mx-auto px-4 py-12">
    
    <a href="/carte" class="inline-flex items-center text-gray-500 hover:text-orange-600 mb-8 transition-colors font-bold group">
        <span class="transform group-hover:-translate-x-1 transition-transform inline-block mr-2">&larr;</span> Retour à la carte
    </a>

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col md:flex-row border border-orange-100">
        
        <div class="md:w-1/2 h-80 md:h-auto relative bg-gray-50">
            <?php if ($pizza->getImageUrl()): ?>
                <img class="absolute inset-0 w-full h-full object-cover" 
                     src="<?= str_starts_with($pizza->getImageUrl(), 'http') ? $pizza->getImageUrl() : '/' . $pizza->getImageUrl() ?>" 
                     alt="<?= htmlspecialchars($pizza->getName()) ?>">
            <?php else: ?>
                <div class="flex items-center justify-center h-full text-gray-300 text-6xl">
                    🍕
                </div>
            <?php endif; ?>
        </div>

        <div class="md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
            <h1 class="text-4xl font-extrabold text-gray-800 mb-4 font-logo"><?= htmlspecialchars($pizza->getName()) ?></h1>
            
            <div class="prose text-gray-600 mb-8 leading-relaxed">
                <h3 class="text-xs font-bold uppercase tracking-widest text-orange-500 mb-2">Ingrédients</h3>
                <p><?= nl2br(htmlspecialchars($pizza->getDescription() ?? 'Aucune description.')) ?></p>
            </div>

            <?php if (empty($options)): ?>
                <div class="bg-orange-50 border-l-4 border-orange-400 p-4 rounded-r-lg">
                    <p class="text-orange-800 font-bold flex items-center gap-2">
                        ⚠️ Non disponible
                        <span class="text-sm font-normal text-orange-700">Prix non configurés pour le moment.</span>
                    </p>
                </div>
            <?php else: ?>
                <form action="/panier/add" method="POST" class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <input type="hidden" name="pizza_id" value="<?= $pizza->getId() ?>">
                    
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wide">Choisir la taille :</label>
                        <div class="space-y-3">
                            <?php foreach ($options as $index => $option): ?>
                                <label class="flex items-center p-4 border-2 rounded-xl cursor-pointer bg-white hover:border-orange-300 transition-all has-[:checked]:border-orange-500 has-[:checked]:bg-orange-50 has-[:checked]:shadow-sm group">
                                    <input type="radio" name="size_id" value="<?= $option['size_id'] ?>" 
                                           class="h-5 w-5 text-orange-600 border-gray-300 focus:ring-orange-500 focus:ring-2"
                                           <?= $index === 0 ? 'checked' : '' ?>>
                                    <div class="ml-4 flex justify-between w-full items-center">
                                        <span class="font-bold text-gray-700 group-hover:text-gray-900"><?= htmlspecialchars($option['label']) ?></span>
                                        <span class="font-bold text-lg text-orange-600"><?= number_format($option['price'], 2) ?> €</span>
                                    </div>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="mb-8">
                        <label for="quantity" class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Quantité :</label>
                        <div class="relative w-32">
                            <select name="quantity" id="quantity" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 py-2 pl-3 pr-10 font-bold text-gray-700 bg-white">
                                <?php for($i=1; $i<=10; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-orange-600 to-red-600 text-white font-bold py-4 px-6 rounded-xl hover:from-orange-700 hover:to-red-700 transition-all duration-300 shadow-lg hover:shadow-orange-500/30 transform hover:-translate-y-0.5 flex justify-center gap-3 items-center text-lg">
                        <span>Ajouter au panier</span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>