<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">📜 Mes Commandes</h1>

    <?php if (empty($orders)): ?>
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-500 text-lg mb-4">Vous n'avez pas encore passé de commande.</p>
            <a href="/carte" class="text-blue-600 hover:underline">Consulter la carte</a>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">N°</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($orders as $order): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                            #<?= $order->getId() ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?= date('d/m/Y H:i', strtotime($order->getCreatedAt())) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <?php 
                                $statusColors = [
                                    'EN_PREPARATION' => 'bg-yellow-100 text-yellow-800',
                                    'EN_LIVRAISON' => 'bg-blue-100 text-blue-800',
                                    'LIVREE' => 'bg-green-100 text-green-800',
                                    'ANNULEE' => 'bg-red-100 text-red-800',
                                ];
                                $class = $statusColors[$order->getStatus()] ?? 'bg-gray-100 text-gray-800';
                            ?>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $class ?>">
                                <?= str_replace('_', ' ', $order->getStatus()) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-gray-900">
                            <?= number_format($order->getTotalPrice(), 2) ?> €
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <a href="/mes-commandes/<?= $order->getId() ?>" class="text-blue-600 hover:text-blue-900 bg-blue-50 px-3 py-1 rounded hover:bg-blue-100 transition">
                                Voir détails
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>