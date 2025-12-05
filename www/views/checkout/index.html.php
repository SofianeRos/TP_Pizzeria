<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto flex flex-col md:flex-row gap-8">
        
        <div class="md:w-2/3">
            <h1 class="text-3xl font-bold mb-6 text-gray-800">📦 Livraison</h1>
            
            <div class="bg-white rounded-lg shadow-lg p-6">
                <form action="/commande/validate" method="POST" class="space-y-4">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                        <input type="text" name="address" required 
                               value="<?= htmlspecialchars($customer->getAddress() ?? '') ?>"
                               placeholder="12 rue de la Paix"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Code Postal</label>
                            <input type="text" name="zipcode" required 
                                   value="<?= htmlspecialchars($customer->getZipcode() ?? '') ?>"
                                   placeholder="75000"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ville</label>
                            <input type="text" name="city" required 
                                   value="<?= htmlspecialchars($customer->getCity() ?? '') ?>"
                                   placeholder="Paris"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                        <input type="tel" name="phone" required 
                               value="<?= htmlspecialchars($customer->getPhone() ?? '') ?>"
                               placeholder="06 12 34 56 78"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-green-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-green-700 transition shadow-md flex justify-between items-center">
                            <span>Confirmer la commande</span>
                            <span><?= number_format($total, 2) ?> €</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="md:w-1/3">
            <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 sticky top-4">
                <h3 class="font-bold text-gray-800 mb-4 text-lg">Récapitulatif</h3>
                <div class="flex justify-between items-center mb-4 text-xl font-bold text-blue-600">
                    <span>Total à payer</span>
                    <span><?= number_format($total, 2) ?> €</span>
                </div>
                <p class="text-sm text-gray-500">
                    Le paiement s'effectuera à la livraison.
                </p>
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <a href="/panier" class="text-sm text-blue-600 hover:underline">Modifier mon panier</a>
                </div>
            </div>
        </div>
    </div>
</div>