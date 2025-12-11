-- 1. Table des Utilisateurs (Clients et Gérants)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(180) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'CLIENT', -- 'CLIENT' ou 'GERANT'
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
 
-- 2. Table des Tailles (Junior, Senior, Mega)
CREATE TABLE sizes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(50) NOT NULL
);
 
-- 3. Table des Pizzas (Infos de base)
CREATE TABLE pizzas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    image_url VARCHAR(255) DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
 
-- 4. Table des Prix (Liaison Pizza <-> Taille)
CREATE TABLE pizza_prices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pizza_id INT NOT NULL,
    size_id INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (pizza_id) REFERENCES pizzas(id) ON DELETE CASCADE,
    FOREIGN KEY (size_id) REFERENCES sizes(id) ON DELETE CASCADE
);
 
-- 5. Table des Ingrédients (avec gestion de stock)
CREATE TABLE ingredients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    stock_quantity INT DEFAULT 0
);
 
-- 6. Liaison Pizza <-> Ingrédients
CREATE TABLE pizza_ingredients (
    pizza_id INT NOT NULL,
    ingredient_id INT NOT NULL,
    PRIMARY KEY(pizza_id, ingredient_id),
    FOREIGN KEY (pizza_id) REFERENCES pizzas(id) ON DELETE CASCADE,
    FOREIGN KEY (ingredient_id) REFERENCES ingredients(id) ON DELETE CASCADE
);
 
-- 7. Table des Commandes (En-tête)
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    status VARCHAR(50) DEFAULT 'EN_PREPARATION', -- 'EN_PREPARATION', 'EN_LIVRAISON', 'LIVREE'
    total_price DECIMAL(10, 2) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
 
-- 8. Détail des Commandes (Lignes de commande)
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    pizza_id INT NOT NULL,
    size_id INT NOT NULL,
    quantity INT NOT NULL,
    price_at_order DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (pizza_id) REFERENCES pizzas(id),
    FOREIGN KEY (size_id) REFERENCES sizes(id)
);