<div class="container mx-auto px-4 py-8">
    <a href="/mes-commandes" class="inline-flex items-center text-gray-500 hover:text-gray-700 mb-6">
        &larr; Retour à mes commandes
    </a>

    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Commande #<?= $order->getId() ?></h1>
                <p class="text-sm text-gray-500">Du <?= date('d/m/Y à H:i', strtotime($order->getCreatedAt())) ?></p>
            </div>
            <div class="text-right">
                <span class="px-3 py-1 rounded-full text-sm font-bold bg-yellow-100 text-yellow-800">
                    <?= str_replace('_', ' ', $order->getStatus()) ?>
                </span>
            </div>
        </div>

        <div class="p-6">
            <h2 class="text-lg font-semibold mb-4">Articles commandés</h2>
            <div class="border rounded-lg overflow-hidden mb-8">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Produit</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Taille</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Qté</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Prix U.</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($items as $item): ?>
                        <tr>
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900"><?= htmlspecialchars($item['pizza_name']) ?></div>
                            </td>
                            <td class="px-4 py-3 text-center text-sm text-gray-500">
                                <?= htmlspecialchars($item['size_label']) ?>
                            </td>
                            <td class="px-4 py-3 text-center text-sm text-gray-900">
                                x<?= $item['quantity'] ?>
                            </td>
                            <td class="px-4 py-3 text-right text-sm text-gray-500">
                                <?= number_format($item['price'], 2) ?> €
                            </td>
                            <td class="px-4 py-3 text-right text-sm font-bold text-gray-900">
                                <?= number_format($item['total'], 2) ?> €
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="4" class="px-4 py-3 text-right font-bold text-gray-900">TOTAL</td>
                            <td class="px-4 py-3 text-right font-bold text-blue-600 text-lg">
                                <?= number_format($order->getTotalPrice(), 2) ?> €
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <h2 class="text-lg font-semibold mb-4">Adresse de livraison</h2>
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <p class="font-medium text-gray-900"><?= htmlspecialchars($order->getDeliveryAddress()) ?></p>
                <p class="text-gray-600">
                    <?= htmlspecialchars($order->getDeliveryZipcode()) ?> <?= htmlspecialchars($order->getDeliveryCity()) ?>
                </p>
                <p class="text-gray-500 mt-2">📞 <?= htmlspecialchars($order->getDeliveryPhone()) ?></p>
            </div>
        </div>
    </div>
</div>