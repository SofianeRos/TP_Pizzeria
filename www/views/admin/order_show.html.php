<div class="container mx-auto px-4 py-8">
    <a href="/admin/orders" class="text-gray-500 hover:text-gray-700 mb-6 inline-block">&larr; Retour aux commandes</a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-gray-800 px-6 py-4 flex justify-between items-center text-white">
                    <h1 class="text-xl font-bold">Commande #<?= $order->getId() ?></h1>
                    <span><?= date('d/m/Y H:i', strtotime($order->getCreatedAt())) ?></span>
                </div>
                
                <div class="p-6">
                    <h3 class="font-bold text-gray-700 mb-4">Contenu de la commande :</h3>
                    <table class="w-full mb-6">
                        <thead>
                            <tr class="text-left text-sm text-gray-500 border-b">
                                <th class="pb-2">Pizza</th>
                                <th class="pb-2">Taille</th>
                                <th class="pb-2 text-right">Qté</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <?php foreach ($items as $item): ?>
                            <tr>
                                <td class="py-3 font-medium"><?= htmlspecialchars($item['pizza_name']) ?></td>
                                <td class="py-3 text-sm text-gray-500"><?= htmlspecialchars($item['size_label']) ?></td>
                                <td class="py-3 text-right font-bold">x<?= $item['quantity'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    
                    <div class="flex justify-end border-t pt-4">
                        <p class="text-xl font-bold text-blue-600">Total : <?= number_format($order->getTotalPrice(), 2) ?> €</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">📍 Adresse de livraison</h3>
                <p class="text-lg"><?= htmlspecialchars($order->getDeliveryAddress()) ?></p>
                <p class="text-gray-600"><?= htmlspecialchars($order->getDeliveryZipcode()) ?> <?= htmlspecialchars($order->getDeliveryCity()) ?></p>
                <div class="mt-4 flex items-center gap-2 text-blue-600 font-bold">
                    <span>📞</span>
                    <a href="tel:<?= htmlspecialchars($order->getDeliveryPhone()) ?>"><?= htmlspecialchars($order->getDeliveryPhone()) ?></a>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                <h3 class="font-bold text-gray-800 mb-4">Mettre à jour le statut</h3>
                
                <form action="/admin/orders/<?= $order->getId() ?>/status" method="POST" class="space-y-4">
                    
                    <?php 
                    $statuses = [
                        'EN_PREPARATION' => '🟡 En préparation',
                        'EN_LIVRAISON' => '🔵 En livraison',
                        'LIVREE' => '🟢 Livrée',
                        'ANNULEE' => '🔴 Annulée'
                    ];
                    ?>

                    <?php foreach ($statuses as $value => $label): ?>
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 has-[:checked]:bg-blue-50 has-[:checked]:border-blue-500">
                        <input type="radio" name="status" value="<?= $value ?>" 
                               class="h-4 w-4 text-blue-600"
                               <?= $order->getStatus() === $value ? 'checked' : '' ?>>
                        <span class="ml-3 font-medium"><?= $label ?></span>
                    </label>
                    <?php endforeach; ?>

                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 shadow-md">
                        Enregistrer
                    </button>
                </form>

                <div class="mt-8 pt-6 border-t">
                    <h4 class="font-bold text-sm text-gray-500 mb-2">Client</h4>
                    <p class="font-medium"><?= htmlspecialchars($client ? $client->getFirstname().' '.$client->getLastname() : 'Inconnu') ?></p>
                    <p class="text-sm text-gray-500"><?= htmlspecialchars($client ? $client->getEmail() : '') ?></p>
                </div>
            </div>
        </div>
    </div>
</div>