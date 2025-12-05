<?php
use JulienLinard\Core\Session\Session;
// Fonction helper pour colorer les statuts 
function getStatusBadge($status) {
    switch ($status) {
        case 'EN_ATTENTE':
            return '<span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide">🕒 En attente</span>';
        case 'EN_PREPARATION':
            return '<span class="bg-orange-100 text-orange-800 py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide">🔥 Au four</span>';
        case 'EN_LIVRAISON':
             return '<span class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide">🛵 En route</span>';
        case 'LIVRE':
            return '<span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide">✅ Livré</span>';
        default:
            return '<span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide">' . $status . '</span>';
    }
}
?>

<div class="container mx-auto px-4 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-4 font-logo">Mes Commandes <span class="text-orange-600">Passées</span></h1>
        <div class="w-24 h-1.5 bg-orange-500 mx-auto rounded-full"></div>
        <p class="text-gray-500 mt-4">Retrouvez l'historique de vos dégustations.</p>
    </div>

    <?php if (empty($orders)): ?>
        <div class="bg-white rounded-3xl shadow-lg p-16 text-center border border-orange-100 max-w-2xl mx-auto">
            <div class="text-6xl mb-6">📜</div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Aucune commande pour le moment.</h2>
            <p class="text-gray-500 mb-8">C'est le moment de craquer pour une pizza !</p>
            <a href="/carte" class="inline-block bg-orange-600 text-white px-8 py-3 rounded-xl hover:bg-orange-700 transition shadow-md font-bold">
                Voir la carte
            </a>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-orange-100">
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="bg-orange-50 text-orange-900 text-left font-bold uppercase text-sm tracking-wider border-b border-orange-100">
                            <th class="px-6 py-4">N° Commande</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4 text-center">Statut</th>
                            </tr>
                    </thead>
                    <tbody class="divide-y divide-orange-50">
                        <?php foreach ($orders as $order): ?>
                            <tr class="hover:bg-orange-50/50 transition-colors">
                                <td class="px-6 py-6 font-bold text-gray-700">
                                    #<?= str_pad($order->getId(), 6, '0', STR_PAD_LEFT) ?>
                                </td>
                                <td class="px-6 py-6 text-gray-600">
                                    <?= date('d/m/Y à H:i', strtotime($order->getCreatedAt())) ?>
                                </td>
                                <td class="px-6 py-6 font-bold text-orange-600 text-lg">
                                    <?= number_format($order->getTotalPrice(), 2) ?> €
                                </td>
                                <td class="px-6 py-6 text-center">
                                    <?= getStatusBadge($order->getStatus()) ?>
                                </td>
                                </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>