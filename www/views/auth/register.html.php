<div class="container mx-auto px-4 py-12 flex justify-center items-center min-h-[80vh]">
    <div class="w-full max-w-2xl bg-white rounded-3xl shadow-2xl overflow-hidden border border-orange-100">
        
        <div class="bg-gradient-to-r from-orange-600 to-red-600 p-8 text-center">
            <h1 class="text-3xl font-bold text-white font-logo mb-2">Bienvenue chez nous !</h1>
            <p class="text-orange-100">Créez votre compte pour commander vos pizzas préférées.</p>
        </div>

        <div class="p-10">
            <form action="/register" method="POST" class="space-y-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="firstname" class="block text-sm font-bold text-gray-700 mb-2">Prénom</label>
                        <input type="text" name="firstname" id="firstname" required placeholder="Mario"
                               class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all">
                    </div>
                    <div>
                        <label for="lastname" class="block text-sm font-bold text-gray-700 mb-2">Nom</label>
                        <input type="text" name="lastname" id="lastname" required placeholder="Rossi"
                               class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Adresse Email</label>
                    <input type="email" name="email" id="email" required placeholder="mario@italie.com"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Mot de passe</label>
                        <input type="password" name="password" id="password" required placeholder="••••••••"
                               class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all">
                        <p class="text-xs text-gray-500 mt-1">Au moins 8 caractères, 1 Maj, 1 Chiffre.</p>
                    </div>

                    <div>
                        <label for="password_confirm" class="block text-sm font-bold text-gray-700 mb-2">Confirmation</label>
                        <input type="password" name="password_confirm" id="password_confirm" required placeholder="••••••••"
                               class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all">
                    </div>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-orange-600 to-red-600 text-white font-bold py-4 px-4 rounded-xl hover:shadow-lg hover:from-orange-700 hover:to-red-700 transition-all transform hover:-translate-y-0.5 text-lg">
                    Créer mon compte maintenant 🍕
                </button>
                
                <p class="text-center text-sm text-gray-500 mt-6">
                    Déjà membre ? <a href="/login" class="text-orange-600 font-bold hover:underline">Se connecter</a>
                </p>
            </form>
        </div>
    </div>
</div>