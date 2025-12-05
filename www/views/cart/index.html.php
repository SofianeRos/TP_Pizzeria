<div class="container mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold mb-8 text-gray-800 font-logo flex items-center gap-3">
        🛒 Mon Panier <span class="text-orange-600">Gourmand</span>
    </h1>

    <?php if (empty($items)): ?>
        <div class="bg-white rounded-3xl shadow-lg p-16 text-center border border-orange-100">
            <div class="bg-orange-50 w-32 h-32 rounded-full flex items-center justify-center mx-auto mb-6">
                <span class="text-7xl">🍕</span>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Votre panier est vide... pour l'instant !</h2>
            <p class="text-gray-500 text-lg mb-8">Nos pizzaiolos s'ennuient, donnez-leur du travail.</p>
            <a href="/carte" class="inline-block bg-gradient-to-r from-orange-600 to-red-600 text-white px-10 py-4 rounded-xl hover:shadow-lg hover:shadow-orange-500/30 transition transform hover:-translate-y-1 font-bold">
                Découvrir la carte
            </a>
        </div>
    <?php else: ?>
        <div class="flex flex-col lg:flex-row gap-8 items-start">
            
            <div class="lg:w-2/3 w-full">
                <div class="bg-white rounded-3xl shadow-lg overflow-hidden border border-gray-100">
                    <table class="w-full">
                        <thead class="bg-orange-50 border-b border-orange-100">
                            <tr>
                                <th class="px-6 py-5 text-left text-sm font-bold text-orange-800 uppercase tracking-wider">Pizza</th>
                                <th class="px-6 py-5 text-center text-sm font-bold text-orange-800 uppercase tracking-wider">Prix U.</th>
                                <th class="px-6 py-5 text-center text-sm font-bold text-orange-800 uppercase tracking-wider">Qté</th>
                                <th class="px-6 py-5 text-right text-sm font-bold text-orange-800 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-5"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach ($items as $item): ?>
                            <tr class="hover:bg-orange-50/30 transition-colors group">
                                <td class="px-6 py-6">
                                    <div class="flex items-center">
                                        <div class="h-16 w-16 flex-shrink-0 rounded-full overflow-hidden border-2 border-orange-100 mr-4">
                                            <?php if ($item['pizza']->getImageUrl()): ?>
                                                <img class="h-full w-full object-cover" 
                                                     src="<?= str_starts_with($item['pizza']->getImageUrl(), 'http') ? $item['pizza']->getImageUrl() : '/' . $item['pizza']->getImageUrl() ?>" 
                                                     alt="">
                                            <?php else: ?>
                                                <div class="h-full w-full bg-orange-50 flex items-center justify-center text-2xl">🍕</div>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <div class="font-bold text-lg text-gray-800 group-hover:text-orange-600 transition-colors font-logo">
                                                <?= htmlspecialchars($item['pizza']->getName()) ?>
                                            </div>
                                            <div class="text-sm text-gray-500 font-medium">
                                                Taille : <span class="text-orange-600"><?= htmlspecialchars($item['size']->getLabel()) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6 text-center text-gray-600 font-medium">
                                    <?= number_format($item['price'], 2) ?> €
                                </td>
                                <td class="px-6 py-6 text-center">
                                    <span class="bg-gray-100 text-gray-800 font-bold py-1 px-3 rounded-lg">
                                        x<?= $item['quantity'] ?>
                                    </span>
                                </td>
                                <td class="px-6 py-6 text-right font-bold text-orange-600 text-lg">
                                    <?= number_format($item['total'], 2) ?> €
                                </td>
                                <td class="px-6 py-6 text-center">
                                    <a href="/panier/remove/<?= $item['pizza']->getId() ?>/<?= $item['size']->getId() ?>" 
                                       class="text-gray-400 hover:text-red-500 hover:bg-red-50 p-2 rounded-full transition-all inline-block"
                                       title="Supprimer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <a href="/panier/clear" class="text-sm text-red-500 hover:text-red-700 hover:underline flex items-center gap-1 font-medium px-4 py-2 hover:bg-red-50 rounded-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Vider tout le panier
                    </a>
                </div>
            </div>

            <div class="lg:w-1/3 w-full sticky top-24">
                <div class="bg-white rounded-3xl shadow-xl p-8 border border-orange-100">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 font-logo border-b border-orange-100 pb-4">Résumé</h2>
                    
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between items-center text-gray-600">
                            <span>Sous-total</span>
                            <span><?= number_format($total, 2) ?> €</span>
                        </div>
                        <div class="flex justify-between items-center text-gray-600">
                            <span>Livraison</span>
                            <span class="text-green-600 font-bold">Gratuite</span>
                        </div>
                        <div class="flex justify-between items-center text-2xl font-bold text-gray-900 pt-4 border-t border-gray-100">
                            <span>Total</span>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-600 to-red-600">
                                <?= number_format($total, 2) ?> €
                            </span>
                        </div>
                    </div>
                    
                    <a href="/commande/livraison" class="block w-full text-center bg-gradient-to-r from-orange-600 to-red-600 text-white py-4 rounded-xl font-bold hover:shadow-lg hover:shadow-orange-500/40 hover:from-orange-700 hover:to-red-700 transition-all transform hover:-translate-y-1">
                        Valider la commande →
                    </a>
                    
                    <div class="mt-6 text-center">
                        <p class="text-xs text-gray-400 mb-2">Paiement sécurisé à la livraison</p>
                        <a href="/carte" class="text-orange-600 hover:text-orange-800 font-medium hover:underline text-sm">
                            J'ai oublié quelque chose ?
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>