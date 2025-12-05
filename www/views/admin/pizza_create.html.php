<?php use JulienLinard\Core\Session\Session; ?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-8 border border-orange-100">
        
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800 font-logo">Nouvelle Pizza</h1>
            <a href="/carte" class="text-gray-500 hover:text-orange-600 font-bold">&larr; Retour</a>
        </div>

        <form action="/admin/pizzas/create" method="POST" enctype="multipart/form-data" class="space-y-6">
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Nom de la pizza *</label>
                <input type="text" name="name" required placeholder="Ex: Reine"
                       class="w-full rounded-xl border-gray-300 border px-4 py-2 outline-none focus:ring-2 focus:ring-orange-500">
            </div>
            
            <div class="grid grid-cols-2 gap-4 bg-orange-50 p-4 rounded-xl border border-orange-100">
                <div class="col-span-1">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Taille *</label>
                    <select name="size_id" class="w-full rounded-xl border-gray-300 border px-4 py-2 outline-none focus:ring-2 focus:ring-orange-500 bg-white">
                        <?php foreach ($sizes as $size): ?>
                            <option value="<?= $size->getId() ?>"><?= htmlspecialchars($size->getLabel()) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-span-1">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Prix (€) *</label>
                    <input type="number" step="0.50" name="price" required placeholder="12.50"
                           class="w-full rounded-xl border-gray-300 border px-4 py-2 outline-none focus:ring-2 focus:ring-orange-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3" class="w-full rounded-xl border-gray-300 border px-4 py-2 outline-none focus:ring-2 focus:ring-orange-500"></textarea>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Image</label>
                <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500">
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-orange-600 to-red-600 text-white font-bold py-3 rounded-xl hover:shadow-lg transition">
                Enregistrer la pizza
            </button>
        </form>
    </div>
</div>