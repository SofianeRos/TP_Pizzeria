</main>
<footer class="bg-gray-800 text-gray-300 py-12 border-t border-gray-700 mt-auto">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

            <div class="col-span-1 md:col-span-1">
                <a href="/" class="text-2xl font-bold text-white flex items-center gap-2 mb-4">
                    🍕 Le Roi Des Pizza
                </a>
                <p class="text-sm text-gray-400">
                    La meilleure pizza de votre vie, livrée chez vous avec passion et rapidité.
                </p>
            </div>

            <div>
                <h3 class="text-white font-bold text-lg mb-4">Liens Rapides</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="/" class="hover:text-yellow-400 transition">Accueil</a></li>
                    <li><a href="/carte" class="hover:text-yellow-400 transition">Notre Carte</a></li>
                    <li><a href="/login" class="hover:text-yellow-400 transition">Connexion</a></li>
                    <li><a href="/register" class="hover:text-yellow-400 transition">Inscription</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-white font-bold text-lg mb-4">Nous Contacter</h3>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start gap-3">
                        <span>📍</span>
                        <span>123 Rue de la Pepperoni,<br>75000 Paris</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span>📞</span>
                        <a href="tel:0123456789" class="hover:text-white">01 23 45 67 89</a>
                    </li>
                    <li class="flex items-center gap-3">
                        <span>✉️</span>
                        <a href="mailto:contact@mapizzeria.fr" class="hover:text-white">contact@mapizzeria.fr</a>
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="text-white font-bold text-lg mb-4">Horaires</h3>
                <ul class="space-y-2 text-sm">
                    <li class="flex justify-between">
                        <span>Lun - Ven :</span>
                        <span class="text-white">11h - 14h / 18h - 22h</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Samedi :</span>
                        <span class="text-white">18h - 23h</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Dimanche :</span>
                        <span class="text-yellow-500 font-bold">Fermé</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-700 mt-10 pt-6 text-center text-sm text-gray-500">
            &copy; <?= date('Y') ?> Ma Pizzeria. Tous droits réservés.
        </div>
    </div>
</footer>

</body>

</html>