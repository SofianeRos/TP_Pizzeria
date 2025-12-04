<?php

use JulienLinard\Core\Session\Session;
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-8">
        
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800"><?= htmlspecialchars($title ?? 'Ajouter une pizza') ?></h1>
            <a href="/carte" class="text-blue-600 hover:text-blue-800 flex items-center gap-2">
                &larr; Retour à la carte
            </a>
        </div>

        <form action="/admin/pizzas/create" method="POST" enctype="multipart/form-data" class="space-y-6">
            
            <input type="hidden" name="csrf_token" value="...">
            
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom de la pizza *</label>
                <input type="text" name="name" id="name" required placeholder="Ex: Reine, 4 Fromages..."
                       class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="3" placeholder="Ingrédients, allergènes..."
                          class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image de la pizza</label>
                <input type="file" name="image" id="image" accept="image/png, image/jpeg, image/webp"
                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="mt-1 text-sm text-gray-500">JPG, PNG ou WebP uniquement.</p>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" 
                        class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors font-medium shadow-sm">
                    Enregistrer la pizza
                </button>
            </div>
        </form>
    </div>
</div>