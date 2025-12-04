<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">🛒 Mon Panier</h1>

    <?php if (empty($items)): ?>
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <div class="text-6xl mb-4">🍽️</div>
            <p class="text-gray-500 text-xl mb-6">Votre panier est vide pour le moment.</p>
            <a href="/carte" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                Découvrir nos pizzas
            </a>
        </div>
    <?php else: ?>
        <div class="flex flex-col lg:flex-row gap-8">
            
            <div class="lg:w-2/3">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Pizza</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase">Prix U.</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase">Qté</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Total</th>
                                <th class="px-6 py-4"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach ($items as $item): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <?php if ($item['pizza']->getImageUrl()): ?>
                                            <img class="h-12 w-12 rounded-full object-cover mr-4 border border-gray-200" 
                                                 src="<?= str_starts_with($item['pizza']->getImageUrl(), 'http') ? $item['pizza']->getImageUrl() : '/' . $item['pizza']->getImageUrl() ?>" 
                                                 alt="">
                                        <?php endif; ?>
                                        <div>
                                            <div class="font-bold text-gray-900">
                                                <?= htmlspecialchars($item['pizza']->getName()) ?>
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                Taille : <?= htmlspecialchars($item['size']->getLabel()) ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center text-gray-600">
                                    <?= number_format($item['price'], 2) ?> €
                                </td>
                                <td class="px-6 py-4 text-center font-medium">
                                    <?= $item['quantity'] ?>
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-blue-600">
                                    <?= number_format($item['total'], 2) ?> €
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="/panier/remove/<?= $item['pizza']->getId() ?>/<?= $item['size']->getId() ?>" 
                                       class="text-red-400 hover:text-red-600 transition-colors p-2"
                                       title="Supprimer">
                                        🗑️
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4 text-right">
                    <a href="/panier/clear" class="text-sm text-red-500 hover:text-red-700 hover:underline">
                        Vider tout le panier
                    </a>
                </div>
            </div>

            <div class="lg:w-1/3">
                <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 border-b pb-2">Résumé</h2>
                    
                    <div class="flex justify-between items-center mb-6">
                        <span class="text-gray-600">Total à payer</span>
                        <span class="text-3xl font-bold text-blue-600"><?= number_format($total, 2) ?> €</span>
                    </div>
                    
                    <a href="/commande/livraison" class="block w-full text-center bg-green-600 text-white py-4 rounded-lg font-bold hover:bg-green-700 transition shadow-lg transform hover:-translate-y-0.5">
                        Valider la commande →
                    </a>
                    
                    <a href="/carte" class="block w-full text-center text-blue-600 mt-4 hover:underline text-sm">
                        Continuer mes achats
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>