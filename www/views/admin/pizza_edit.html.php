<?php use JulienLinard\Core\Session\Session; ?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-8">
        
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Modifier la pizza</h1>
            <a href="/carte" class="text-blue-600 hover:text-blue-800 flex items-center gap-2">
                &larr; Annuler
            </a>
        </div>

        <form action="/admin/pizzas/edit/<?= $pizza->getId() ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom de la pizza *</label>
                <input type="text" name="name" id="name" required 
                       value="<?= htmlspecialchars($pizza->getName()) ?>"
                       class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="3" 
                          class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500"><?= htmlspecialchars($pizza->getDescription() ?? '') ?></textarea>
            </div>

            <?php if ($pizza->getImageUrl()): ?>
            <div class="mb-4">
                <p class="text-sm font-medium text-gray-700 mb-2">Image actuelle :</p>
                <img src="<?= str_starts_with($pizza->getImageUrl(), 'http') ? $pizza->getImageUrl() : '/' . $pizza->getImageUrl() ?>" 
                     alt="Aperçu" class="h-32 rounded-lg border border-gray-200 object-cover">
            </div>
            <?php endif; ?>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Changer l'image (optionnel)</label>
                <input type="file" name="image" id="image" accept="image/png, image/jpeg, image/webp"
                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="mt-1 text-sm text-gray-500">Laissez vide pour garder l'image actuelle.</p>
            </div>

            <div class="flex justify-end pt-4 gap-4">
                <a href="/carte" class="px-6 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">Annuler</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 font-medium shadow-sm">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>