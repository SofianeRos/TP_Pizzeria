<?php use JulienLinard\Core\Session\Session; ?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden border border-orange-100">
        
        <div class="p-8 border-b border-gray-100 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800 font-logo">Modifier la pizza</h1>
            <a href="/carte" class="text-gray-500 hover:text-orange-600 font-bold">&larr; Retour</a>
        </div>

        <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="md:col-span-2">
                <form action="/admin/pizzas/edit/<?= $pizza->getId() ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nom</label>
                        <input type="text" name="name" required value="<?= htmlspecialchars($pizza->getName()) ?>"
                            class="w-full rounded-xl border-gray-300 border px-4 py-2 outline-none focus:ring-2 focus:ring-orange-500">
                    </div>

                    <div class="bg-orange-50 p-4 rounded-xl border border-orange-200">
                        <h3 class="font-bold text-orange-800 mb-3 text-sm uppercase">Définir un prix</h3>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-xs font-bold text-gray-500 block mb-1">Taille</label>
                                <select name="size_id" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-orange-500">
                                    <option value="">Choisir...</option>
                                    <?php foreach ($sizes as $size): ?>
                                        <option value="<?= $size->getId() ?>"><?= htmlspecialchars($size->getLabel()) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-500 block mb-1">Prix (€)</label>
                                <input type="number" step="0.50" name="price" placeholder="0.00"
                                    class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-orange-500">
                            </div>
                        </div>
                        <p class="text-xs text-orange-600 mt-2">Sélectionnez une taille et entrez un prix pour l'ajouter ou le modifier.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="4" 
                                class="w-full rounded-xl border-gray-300 border px-4 py-2 outline-none focus:ring-2 focus:ring-orange-500"><?= htmlspecialchars($pizza->getDescription() ?? '') ?></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Image</label>
                        <div class="flex items-center gap-4">
                            <?php if ($pizza->getImageUrl()): ?>
                                <img src="<?= str_starts_with($pizza->getImageUrl(), 'http') ? $pizza->getImageUrl() : '/' . $pizza->getImageUrl() ?>" class="w-16 h-16 rounded-lg object-cover border border-gray-200">
                            <?php endif; ?>
                            <input type="file" name="image" class="text-sm text-gray-500">
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-md">
                            💾 Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>

            <div class="md:col-span-1">
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 sticky top-4">
                    <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Tarifs actuels</h3>
                    
                    <?php if (empty($currentPrices)): ?>
                        <p class="text-sm text-gray-500 italic">Aucun prix configuré.</p>
                    <?php else: ?>
                        <ul class="space-y-3">
                            <?php foreach ($currentPrices as $cp): ?>
                                <li class="flex justify-between items-center bg-white p-3 rounded-lg shadow-sm border border-gray-100">
                                    <span class="font-bold text-gray-700"><?= htmlspecialchars($cp['label']) ?></span>
                                    <span class="font-bold text-green-600"><?= number_format($cp['price'], 2) ?> €</span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <form action="/admin/pizzas/delete/<?= $pizza->getId() ?>" method="POST" onsubmit="return confirm('Supprimer définitivement ?');">
                            <button type="submit" class="w-full text-red-600 hover:text-white hover:bg-red-600 border border-red-200 font-bold text-sm py-2 rounded-lg transition-colors flex justify-center items-center gap-2">
                                🗑️ Supprimer la pizza
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>