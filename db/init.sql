-- MariaDB dump 10.19-11.3.2-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: pizzeria_db
-- ------------------------------------------------------
-- Server version	11.3.2-MariaDB-1:11.3.2+maria~ubu2204

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ingredients`
--

DROP TABLE IF EXISTS `ingredients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ingredients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `stock_quantity` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingredients`
--

LOCK TABLES `ingredients` WRITE;
/*!40000 ALTER TABLE `ingredients` DISABLE KEYS */;
/*!40000 ALTER TABLE `ingredients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `pizza_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_at_order` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `pizza_id` (`pizza_id`),
  KEY `size_id` (`size_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`pizza_id`) REFERENCES `pizzas` (`id`),
  CONSTRAINT `order_items_ibfk_3` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES
(1,1,4,3,2,15.00),
(2,2,4,3,1,15.00),
(3,3,5,3,17,15.00),
(4,4,5,1,1,9.50),
(5,5,4,3,1,15.00);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `status` varchar(50) DEFAULT 'EN_PREPARATION',
  `total_price` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `delivery_address` varchar(255) NOT NULL,
  `delivery_zipcode` varchar(10) NOT NULL,
  `delivery_city` varchar(100) NOT NULL,
  `delivery_phone` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES
(1,5,'ANNULEE',30.00,'2025-12-05 11:06:38','12 rue de la paix ','75000','Paris','0612458966'),
(2,5,'LIVREE',15.00,'2025-12-05 14:38:07','12 rue de la paix ','75000','Paris','0612458966'),
(3,5,'LIVREE',255.00,'2025-12-05 14:52:00','12 rue de la paix ','75000','Paris','0612458966'),
(4,6,'EN_LIVRAISON',9.50,'2025-12-05 15:28:50','12 rue de la paix ','75000','Paris','0612458966'),
(5,6,'EN_PREPARATION',15.00,'2025-12-08 08:48:49','12 rue de la paix ','75000','Paris','0612458966');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pizza_ingredients`
--

DROP TABLE IF EXISTS `pizza_ingredients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pizza_ingredients` (
  `pizza_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  PRIMARY KEY (`pizza_id`,`ingredient_id`),
  KEY `ingredient_id` (`ingredient_id`),
  CONSTRAINT `pizza_ingredients_ibfk_1` FOREIGN KEY (`pizza_id`) REFERENCES `pizzas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pizza_ingredients_ibfk_2` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pizza_ingredients`
--

LOCK TABLES `pizza_ingredients` WRITE;
/*!40000 ALTER TABLE `pizza_ingredients` DISABLE KEYS */;
/*!40000 ALTER TABLE `pizza_ingredients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pizza_prices`
--

DROP TABLE IF EXISTS `pizza_prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pizza_prices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pizza_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pizza_id` (`pizza_id`),
  KEY `size_id` (`size_id`),
  CONSTRAINT `pizza_prices_ibfk_1` FOREIGN KEY (`pizza_id`) REFERENCES `pizzas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pizza_prices_ibfk_2` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pizza_prices`
--

LOCK TABLES `pizza_prices` WRITE;
/*!40000 ALTER TABLE `pizza_prices` DISABLE KEYS */;
INSERT INTO `pizza_prices` VALUES
(4,4,1,9.50),
(5,4,2,12.00),
(6,4,3,15.00),
(7,5,1,9.50),
(8,5,2,12.00),
(9,5,3,15.00),
(10,6,1,9.50),
(11,6,2,12.00),
(12,6,3,15.00),
(13,8,1,9.50),
(14,8,2,12.00),
(15,8,3,15.00),
(16,9,1,9.50),
(17,9,2,12.00),
(18,9,3,15.00);
/*!40000 ALTER TABLE `pizza_prices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pizzas`
--

DROP TABLE IF EXISTS `pizzas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pizzas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pizzas`
--

LOCK TABLES `pizzas` WRITE;
/*!40000 ALTER TABLE `pizzas` DISABLE KEYS */;
INSERT INTO `pizzas` VALUES
(4,'Reine','L\'indétrônable classique qui met tout le monde d\'accord. Sur notre sauce tomate maison, retrouvez le mariage intemporel du jambon cuit et des champignons de Paris frais émincés. Le tout généreusement couvert de mozzarella fondante et d\'une pincée d\'origan. Simple, équilibrée et toujours délicieuse','uploads/pizzas/pizza_6932a1f4ea36e.png','2025-12-05 08:38:11'),
(5,'4 fromages ','4 fois plus de plaisir. La légende de la carte ! Un mix puissant de Gorgonzola, Chèvre, Emmental et Mozzarella gratinés à la perfection. C\'est crémeux, c\'est fort en goût et c\'est ultra-gourmand. La valeur sûre pour les grosses faims.','uploads/pizzas/pizza_6932b9f07e78f.png','2025-12-05 10:54:40'),
(6,'Chevre Miel ','Laissez-vous tenter par l\'incontournable du sucré-salé. Sur une base de crème fraîche onctueuse, nous avons marié la force de caractère de la bûche de chèvre à la douceur florale du miel. Le tout est gratiné à la mozzarella fondante et parsemé d\'origan [ou noix/thym]. Une pizza réconfortante, où chaque bouchée est un équilibre parfait.','uploads/pizzas/pizza_6932bb6f9ac2b.png','2025-12-05 11:01:03'),
(8,'Norvegienne ','Le grand frisson du Grand Nord dans votre assiette. Sur une base crème onctueuse et gratinée, laissez-vous emporter par la saveur unique du saumon fumé  Une pizza généreuse, relevée par une touche citronnée et des herbes fraîches. L\'alliance parfaite de la douceur et du goût iodé.','uploads/pizzas/pizza_6932d4e3cbf1e.png','2025-12-05 12:49:39'),
(9,'Margherita ','L\'hymne à l\'Italie dans sa plus pure tradition. Une pâte maturée à la perfection, notre sauce tomate cuisinée avec amour et de la mozzarella fondante. Rehaussée par quelques feuilles de basilic frais et un filet d\'huile d\'olive. Le retour aux sources du goût, tout simplement.','uploads/pizzas/pizza_6932d632c285f.png','2025-12-05 12:55:14');
/*!40000 ALTER TABLE `pizzas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sizes`
--

DROP TABLE IF EXISTS `sizes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sizes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sizes`
--

LOCK TABLES `sizes` WRITE;
/*!40000 ALTER TABLE `sizes` DISABLE KEYS */;
INSERT INTO `sizes` VALUES
(1,'Junior'),
(2,'Senior'),
(3,'Mega');
/*!40000 ALTER TABLE `sizes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(180) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'CLIENT',
  `created_at` datetime DEFAULT current_timestamp(),
  `address` varchar(255) DEFAULT NULL,
  `zipcode` varchar(10) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(4,'jean','soooooo','dusjuhdhjdzkj@gmail.com','$2y$10$x9yeGKRe2PiqrGzf0ZS5zupJ8hhsVJWs/kyhHLiriA8p1KWQZhVmK','GERANT','2025-12-04 13:00:47',NULL,NULL,NULL,NULL),
(5,'jean client','test','testclient@gmail.com','$2y$10$VPSFujHW5XK2OgKRYlOHDeDmQz3vRbxLWNYYRJxrGc6AjCyviZmuW','CLIENT','2025-12-05 09:43:43',NULL,NULL,NULL,NULL),
(6,'Client','Un','client@1.com','$2y$10$AtL4HZhTC76R8Sqht8AnT.4eIkJ1iDh9bEv2O6V9nO.9K4UPVCHnK','CLIENT','2025-12-05 14:27:20',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-11  7:57:56
