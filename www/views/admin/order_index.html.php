<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">👨‍🍳 Commandes Reçues</h1>
        <a href="/admin/pizzas/create" class="text-blue-600 hover:underline">Gérer les pizzas</a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-6 py-3 text-left">N°</th>
                    <th class="px-6 py-3 text-left">Date</th>
                    <th class="px-6 py-3 text-left">Client</th>
                    <th class="px-6 py-3 text-center">Statut</th>
                    <th class="px-6 py-3 text-right">Montant</th>
                    <th class="px-6 py-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php foreach ($ordersList as $row): 
                    $order = $row['order'];
                ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-bold">#<?= $order->getId() ?></td>
                    <td class="px-6 py-4 text-sm"><?= date('d/m H:i', strtotime($order->getCreatedAt())) ?></td>
                    <td class="px-6 py-4"><?= htmlspecialchars($row['client_name']) ?></td>
                    <td class="px-6 py-4 text-center">
                        <?php 
                            $colors = [
                                'EN_PREPARATION' => 'bg-yellow-100 text-yellow-800',
                                'EN_LIVRAISON' => 'bg-blue-100 text-blue-800',
                                'LIVREE' => 'bg-green-100 text-green-800',
                                'ANNULEE' => 'bg-red-100 text-red-800',
                            ];
                            $class = $colors[$order->getStatus()] ?? 'bg-gray-100';
                        ?>
                        <span class="px-2 py-1 rounded-full text-xs font-bold <?= $class ?>">
                            <?= str_replace('_', ' ', $order->getStatus()) ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right font-bold"><?= number_format($order->getTotalPrice(), 2) ?> €</td>
                    <td class="px-6 py-4 text-center">
                        <a href="/admin/orders/<?= $order->getId() ?>" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                            Gérer
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>