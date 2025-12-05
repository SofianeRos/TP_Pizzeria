<div class="container mx-auto px-4 py-16 flex justify-center items-center min-h-[80vh]">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden border border-orange-100">
        
        <div class="bg-gradient-to-r from-orange-500 to-red-600 p-8 text-center">
            <h1 class="text-4xl font-bold text-white font-logo mb-2">Bon Retour !</h1>
            <p class="text-orange-100">Connectez-vous pour commander</p>
        </div>

        <div class="p-10">
            <form action="/login" method="POST" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Adresse Email</label>
                    <input type="email" name="email" id="email" required 
                           class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all"
                           placeholder="vous@exemple.com">
                </div>

                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Mot de passe</label>
                    <input type="password" name="password" id="password" required 
                           class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all"
                           placeholder="••••••••">
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-orange-600 to-red-600 text-white font-bold py-3.5 px-4 rounded-xl hover:shadow-lg hover:from-orange-700 hover:to-red-700 transition-all transform hover:-translate-y-0.5">
                    Se connecter
                </button>
                
                <p class="text-center text-sm text-gray-500 mt-6">
                    Pas encore de compte ? <a href="/register" class="text-orange-600 font-bold hover:underline">Créer un compte</a>
                </p>
            </form>
        </div>
    </div>
</div>