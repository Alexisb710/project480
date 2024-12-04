-- MySQL dump 10.13  Distrib 9.0.1, for macos14 (arm64)
--
-- Host: localhost    Database: project480
-- ------------------------------------------------------
-- Server version	9.0.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('test@example.com|127.0.0.1','i:1;',1732560945),('test@example.com|127.0.0.1:timer','i:1732560945;',1732560945);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `price` decimal(8,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `carts_user_id_foreign` (`user_id`),
  KEY `carts_product_id_foreign` (`product_id`),
  CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=318 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
INSERT INTO `carts` VALUES (153,7,2,'2024-11-23 08:15:27','2024-11-23 08:15:27',1,0.00),(259,10,8,'2024-11-24 07:35:01','2024-11-24 07:35:01',1,0.00),(260,10,10,'2024-11-24 07:35:05','2024-11-24 07:35:05',2,0.00),(262,10,11,'2024-11-24 07:36:23','2024-11-24 07:36:40',11,0.00),(263,10,1,'2024-11-24 07:39:39','2024-11-24 07:39:39',1,0.00),(315,1,11,'2024-11-26 01:47:06','2024-11-26 02:46:04',5,0.00),(316,1,10,'2024-11-26 02:45:37','2024-11-26 02:45:37',1,0.00),(317,1,23,'2024-11-26 02:48:00','2024-11-26 02:48:00',1,0.00);
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (2,'Home Gym Equipment','2024-10-31 07:11:16','2024-11-22 09:05:37'),(6,'Climbing','2024-11-04 09:23:44','2024-11-04 09:23:44'),(7,'Baseball','2024-11-22 09:05:49','2024-11-22 09:05:49'),(8,'Rehabilitation','2024-11-22 09:06:15','2024-11-22 09:06:15'),(9,'Snow Sports','2024-11-22 09:06:37','2024-11-22 09:06:37'),(10,'Running','2024-11-22 09:06:41','2024-11-22 09:06:41'),(11,'Boxing','2024-11-22 09:06:48','2024-11-22 09:06:48'),(12,'Crossfit','2024-11-22 09:13:55','2024-11-22 09:13:55');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2024_10_30_235332_create_categories_table',2),(7,'2024_10_31_042641_create_products_table',3),(8,'2024_11_01_212209_create_carts_table',3),(9,'2024_11_02_205900_create_orders_table',4),(10,'2024_11_03_014704_add_payment_status_to_orders_table',5),(11,'2024_11_04_014547_add_slug_column_to_products_table',6),(12,'2024_11_09_031520_create_order_items_table',7),(13,'2024_11_09_034801_add_order_number_to_orders_table',8),(14,'2024_11_09_060858_remove_product_id_from_orders_table',9),(15,'2024_11_09_062133_add_quantity_to_carts_table',10),(16,'2024_11_09_062804_add_price_to_carts_table',11),(17,'2024_11_09_063353_change_price_column_in_products_table',12),(18,'2024_11_09_070628_add_total_price_to_orders_table',13),(19,'2024_11_09_085028_update_default_quantity_in_carts_table',14);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (17,23,2,3,129.99,'2024-11-09 17:34:03','2024-11-09 17:34:03'),(18,23,1,3,35.99,'2024-11-09 17:34:03','2024-11-09 17:34:03'),(19,24,1,1,35.99,'2024-11-10 03:13:22','2024-11-10 03:13:22'),(20,24,2,1,129.99,'2024-11-10 03:13:22','2024-11-10 03:13:22'),(21,24,3,1,39.99,'2024-11-10 03:13:22','2024-11-10 03:13:22'),(22,24,6,1,39.99,'2024-11-10 03:13:22','2024-11-10 03:13:22'),(23,25,1,1,35.99,'2024-11-10 03:20:33','2024-11-10 03:20:33'),(24,25,5,1,69.99,'2024-11-10 03:20:33','2024-11-10 03:20:33'),(25,26,4,1,12.99,'2024-11-10 03:21:37','2024-11-10 03:21:37'),(26,27,2,2,129.99,'2024-11-10 06:45:57','2024-11-10 06:45:57'),(27,27,7,1,44.99,'2024-11-10 06:45:57','2024-11-10 06:45:57'),(28,27,8,1,13.99,'2024-11-10 06:45:57','2024-11-10 06:45:57'),(33,29,1,2,35.99,'2024-11-12 09:21:06','2024-11-12 09:21:06'),(34,29,4,2,12.99,'2024-11-12 09:21:06','2024-11-12 09:21:06'),(35,29,5,1,69.99,'2024-11-12 09:21:06','2024-11-12 09:21:06'),(36,29,9,1,51.99,'2024-11-12 09:21:06','2024-11-12 09:21:06'),(37,30,2,1,129.99,'2024-11-13 04:41:32','2024-11-13 04:41:32'),(38,30,3,1,39.99,'2024-11-13 04:41:32','2024-11-13 04:41:32'),(39,30,5,1,69.99,'2024-11-13 04:41:32','2024-11-13 04:41:32'),(40,30,8,1,13.99,'2024-11-13 04:41:32','2024-11-13 04:41:32'),(41,31,3,2,39.99,'2024-11-13 04:44:56','2024-11-13 04:44:56'),(42,32,7,1,44.99,'2024-11-13 04:54:15','2024-11-13 04:54:15'),(43,34,2,1,129.99,'2024-11-14 05:17:55','2024-11-14 05:17:55'),(44,35,3,1,39.99,'2024-11-14 05:37:20','2024-11-14 05:37:20'),(45,36,10,1,149.99,'2024-11-23 04:14:54','2024-11-23 04:14:54'),(46,36,11,1,7.99,'2024-11-23 04:14:54','2024-11-23 04:14:54'),(47,36,9,2,51.99,'2024-11-23 04:14:54','2024-11-23 04:14:54'),(48,37,5,1,69.99,'2024-11-23 04:17:21','2024-11-23 04:17:21'),(49,37,14,1,199.99,'2024-11-23 04:17:21','2024-11-23 04:17:21'),(50,37,21,1,18.00,'2024-11-23 04:17:21','2024-11-23 04:17:21'),(51,38,2,1,129.99,'2024-11-23 04:19:45','2024-11-23 04:19:45'),(52,38,4,1,12.99,'2024-11-23 04:19:45','2024-11-23 04:19:45'),(53,38,8,3,13.99,'2024-11-23 04:19:45','2024-11-23 04:19:45'),(54,38,20,2,32.99,'2024-11-23 04:19:45','2024-11-23 04:19:45'),(55,39,16,1,1399.99,'2024-11-23 08:14:59','2024-11-23 08:14:59'),(56,39,21,1,18.00,'2024-11-23 08:14:59','2024-11-23 08:14:59'),(57,39,22,1,199.99,'2024-11-23 08:14:59','2024-11-23 08:14:59'),(58,39,23,1,267.99,'2024-11-23 08:14:59','2024-11-23 08:14:59'),(59,39,24,1,44.99,'2024-11-23 08:14:59','2024-11-23 08:14:59'),(60,39,20,1,32.99,'2024-11-23 08:14:59','2024-11-23 08:14:59'),(61,39,19,1,109.99,'2024-11-23 08:14:59','2024-11-23 08:14:59'),(62,39,3,1,39.99,'2024-11-23 08:14:59','2024-11-23 08:14:59'),(63,39,8,3,13.99,'2024-11-23 08:14:59','2024-11-23 08:14:59'),(64,40,19,5,109.99,'2024-11-23 16:09:09','2024-11-23 16:09:09'),(65,40,20,3,32.99,'2024-11-23 16:09:09','2024-11-23 16:09:09'),(66,40,21,2,18.00,'2024-11-23 16:09:09','2024-11-23 16:09:09'),(67,40,2,1,129.99,'2024-11-23 16:09:09','2024-11-23 16:09:09'),(68,40,3,3,39.99,'2024-11-23 16:09:09','2024-11-23 16:09:09'),(69,41,3,1,39.99,'2024-11-23 16:09:57','2024-11-23 16:09:57'),(70,41,23,1,267.99,'2024-11-23 16:09:57','2024-11-23 16:09:57'),(71,41,22,1,199.99,'2024-11-23 16:09:57','2024-11-23 16:09:57'),(72,41,24,1,44.99,'2024-11-23 16:09:57','2024-11-23 16:09:57'),(73,42,12,1,34.99,'2024-11-24 07:01:21','2024-11-24 07:01:21'),(74,42,13,1,79.99,'2024-11-24 07:01:21','2024-11-24 07:01:21'),(75,42,18,2,25.00,'2024-11-24 07:01:21','2024-11-24 07:01:21'),(76,42,21,1,18.00,'2024-11-24 07:01:21','2024-11-24 07:01:21'),(77,42,19,2,109.99,'2024-11-24 07:01:21','2024-11-24 07:01:21'),(78,42,2,1,129.99,'2024-11-24 07:01:21','2024-11-24 07:01:21'),(79,42,15,2,399.99,'2024-11-24 07:01:21','2024-11-24 07:01:21'),(80,43,1,1,35.99,'2024-11-24 07:03:24','2024-11-24 07:03:24'),(81,43,7,1,44.99,'2024-11-24 07:03:24','2024-11-24 07:03:24'),(82,44,2,2,129.99,'2024-11-24 07:33:31','2024-11-24 07:33:31'),(83,45,8,4,13.99,'2024-11-24 08:22:54','2024-11-24 08:22:54'),(84,45,24,2,44.99,'2024-11-24 08:22:54','2024-11-24 08:22:54'),(85,45,6,1,39.99,'2024-11-24 08:22:54','2024-11-24 08:22:54'),(86,45,7,1,44.99,'2024-11-24 08:22:54','2024-11-24 08:22:54'),(87,45,5,1,69.99,'2024-11-24 08:22:54','2024-11-24 08:22:54'),(88,45,9,1,51.99,'2024-11-24 08:22:54','2024-11-24 08:22:54'),(89,45,10,1,149.99,'2024-11-24 08:22:54','2024-11-24 08:22:54'),(90,46,2,1,129.99,'2024-11-24 08:23:41','2024-11-24 08:23:41'),(91,46,3,1,39.99,'2024-11-24 08:23:41','2024-11-24 08:23:41'),(92,46,4,1,12.99,'2024-11-24 08:23:41','2024-11-24 08:23:41'),(93,47,11,10,7.99,'2024-11-24 08:47:18','2024-11-24 08:47:18'),(94,47,10,2,149.99,'2024-11-24 08:47:18','2024-11-24 08:47:18'),(95,48,8,1,13.99,'2024-11-24 08:48:04','2024-11-24 08:48:04'),(96,49,19,1,109.99,'2024-11-24 09:30:02','2024-11-24 09:30:02'),(102,52,16,2,1399.99,'2024-11-26 01:46:47','2024-11-26 01:46:47'),(103,52,18,3,25.00,'2024-11-26 01:46:47','2024-11-26 01:46:47'),(104,52,3,2,39.99,'2024-11-26 01:46:47','2024-11-26 01:46:47');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rec_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'in progress',
  `user_id` bigint unsigned NOT NULL,
  `payment_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Cash on Delivery',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (23,'ORDER_672F2C8B97183','user','12345 five st, northridge, ca 91301','1234567891','Delivered',1,'Cash on Delivery','2024-11-09 17:34:03','2024-11-12 09:24:24',497.94),(24,'ORDER_672FB452BCBAC','user','12345 five st, northridge, ca 91301','1234567891','Delivered',1,'Cash on Delivery','2024-11-10 03:13:22','2024-11-12 09:23:12',245.96),(25,'ORDER_672FB601AEE98','user','12345 five st, northridge, ca 91301','1234567891','On the way',1,'Cash on Delivery','2024-11-10 03:20:33','2024-11-10 06:08:11',105.98),(26,'ORDER_672FB6412C004','user','12345 five st, northridge, ca 91301','1234567891','Delivered',1,'Cash on Delivery','2024-11-10 03:21:37','2024-11-10 06:08:07',12.99),(27,'ORDER_672FE625AE592','User','12345 five st, northridge, ca 91301','1234567891','in progress',1,'Cash on Delivery','2024-11-10 06:45:57','2024-11-10 06:45:57',318.96),(29,'ORDER_6732AD81F2AD6','User1','12345 five st, northridge, ca 91301','(313)456-7891','in progress',1,'Cash on Delivery','2024-11-12 09:21:05','2024-11-12 09:21:05',219.94),(30,'ORDER_6733BD7CCBAC4','User10','12345 five st, northridge, ca 91301','(313)456-7891','in progress',1,'Paid with Card','2024-11-13 04:41:32','2024-11-13 04:41:32',253.96),(31,'ORDER_6733BE487A5C8','User10','12345 five st, northridge, ca 91301','(313)456-7891','in progress',1,'Paid with Card','2024-11-13 04:44:56','2024-11-13 04:44:56',79.98),(32,'ORDER_6733C0770FA0C','User10','12345 five st, northridge, ca 91301','(313)456-7891','in progress',1,'Paid with Card','2024-11-13 04:54:15','2024-11-13 04:54:15',44.99),(33,'ORDER_6733C08332384','User10','12345 five st, northridge, ca 91301','(313)456-7891','in progress',1,'Cash on Delivery','2024-11-13 04:54:27','2024-11-13 04:54:27',0.00),(34,'ORDER_67351783AB244','User10','12345 five st, northridge, ca 91301','(313)456-7891','in progress',1,'Paid with Card','2024-11-14 05:17:55','2024-11-14 05:17:55',129.99),(35,'ORDER_67351C10E8B61','User10','12345 five st, northridge, ca 91301','(313)456-7891','in progress',1,'Paid with Card','2024-11-14 05:37:20','2024-11-14 05:37:20',39.99),(36,'ORDER_6740E63EC27F5','John Doe','123 Main St, Springfield, IL 62704','(555)123-4567','in progress',7,'Cash on Delivery','2024-11-23 04:14:54','2024-11-23 04:14:54',261.96),(37,'ORDER_6740E6D17C52E','Alice Smith','456 Oak St, Metropolis, IL 62960','(555)234-5678','in progress',8,'Paid with Card','2024-11-23 04:17:21','2024-11-23 04:17:21',287.98),(38,'ORDER_6740E761D4FD5','Bob Johnson','789 Pine St, Smallville, KS 67524','(555)345-6789','in progress',9,'Cash on Delivery','2024-11-23 04:19:45','2024-11-23 04:19:45',250.93),(39,'ORDER_67411E834DEC5','John Doe','123 Main St, Springfield, IL 62704','(555)123-4567','in progress',7,'Paid with Card','2024-11-23 08:14:59','2024-11-23 08:14:59',2155.90),(40,'ORDER_67418DA5CF3F0','Alice Smith','456 Oak St, Metropolis, IL 62960','(555)234-5678','in progress',8,'Cash on Delivery','2024-11-23 16:09:09','2024-11-23 16:09:09',934.88),(41,'ORDER_67418DD5619B0','Alice Smith','456 Oak St, Metropolis, IL 62960','(555)234-5678','in progress',8,'Paid with Card','2024-11-23 16:09:57','2024-11-23 16:09:57',552.96),(42,'ORDER_67425EC109948','Charlie Brown','101 Maple St, Gotham, NY 10001','(555)456-7890','in progress',10,'Paid with Card','2024-11-24 07:01:21','2024-11-24 07:01:21',1332.93),(43,'ORDER_67425F3C8FF95','Charlie Brown','101 Maple St, Gotham, NY 10001','(555)456-7890','in progress',10,'Cash on Delivery','2024-11-24 07:03:24','2024-11-24 07:03:24',80.98),(44,'ORDER_6742664BA118E','Charlie Brown','101 Maple St, Gotham, NY 10001','(555)456-7890','in progress',10,'Cash on Delivery','2024-11-24 07:33:31','2024-11-24 07:33:31',259.98),(45,'ORDER_674271DEBE345','Alice Smith','456 Oak St, Metropolis, IL 62960','(555)234-5678','in progress',8,'Paid with Card','2024-11-24 08:22:54','2024-11-24 08:22:54',502.89),(46,'ORDER_6742720D024FB','Alice Smith','456 Oak St, Metropolis, IL 62960','(555)234-5678','in progress',8,'Cash on Delivery','2024-11-24 08:23:41','2024-11-24 08:23:41',182.97),(47,'ORDER_674277963FC1A','Bob Johnson','789 Pine St, Smallville, KS 67524','(555)345-6789','in progress',9,'Paid with Card','2024-11-24 08:47:18','2024-11-24 08:47:18',379.88),(48,'ORDER_674277C4D013D','Bob Johnson','789 Pine St, Smallville, KS 67524','(555)345-6789','in progress',9,'Cash on Delivery','2024-11-24 08:48:04','2024-11-24 08:48:04',13.99),(49,'ORDER_6742819A6CC8D','Bob Johnson','789 Pine St, Smallville, KS 67524','(555)345-6789','in progress',9,'Cash on Delivery','2024-11-24 09:30:02','2024-11-24 09:30:02',109.99),(52,'ORDER_6744B8072E815','User10','12345 five st, northridge, ca 91301','(313)456-7891','in progress',1,'Cash on Delivery','2024-11-26 01:46:47','2024-11-26 01:46:47',2954.96);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
INSERT INTO `password_reset_tokens` VALUES ('test@example.com','$2y$12$ctXbDPQv45apNPv7PODuw.3BVcyaPeBydRwodzDNsAi4OgrYS5gBW','2024-11-26 02:51:21');
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(8,2) NOT NULL,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Sandbag','30lb sandbag. Great for exercise.','1730584376.jpeg',35.99,'Home Gym Equipment','21','sandbag-1','2024-11-03 04:52:56','2024-11-22 11:30:37'),(2,'Treadmill','Electric treadmill. Great for running indoors and at home.','1730584434.jpeg',129.99,'Home Gym Equipment','15','treadmill-1','2024-11-03 04:53:54','2024-11-22 11:30:45'),(3,'40lb Dumbbell','40lb dumbbell (single)','1730584513.jpeg',39.99,'Home Gym Equipment','47','forty-lb-dumbell-1','2024-11-03 04:55:13','2024-11-22 11:30:31'),(4,'Climbing Rope','Strong rope. Great for climbing.','1730584557.jpeg',12.99,'Climbing','50','rope-1','2024-11-03 04:55:57','2024-11-22 08:30:58'),(5,'Running shoes','Great for long-distance running and everyday wear.','1730584612.jpg',69.99,'Running','30','shoes-1','2024-11-03 04:56:52','2024-11-22 11:30:25'),(6,'45lb Barbell','A 45lb barbell (no weights included).','1730682743.jpg',39.99,'Home Gym Equipment','18','forty-five-barbell-1','2024-11-04 09:12:23','2024-11-22 11:30:56'),(7,'50lb Kettlebell','50lb Kettlebell. Great for swings and other exercises.','1730682817.webp',44.99,'Home Gym Equipment','8','fifty-lb-kettlebell-1','2024-11-04 09:13:37','2024-11-22 11:31:09'),(8,'Chalk','Great chalk for climbing mountains, lifting weights, and gymnastics.','1730682894.webp',13.99,'Climbing','26','chalk-1','2024-11-04 09:14:54','2024-11-22 11:31:25'),(9,'Battlerope','Hefty battle rope for a really serious shoulder exercise or any other form of cardio exercise.','1730682973.jpg',51.99,'Home Gym Equipment','9','battlerope-1','2024-11-04 09:16:13','2024-11-22 11:31:33'),(10,'Baseball Bat','Aluminum Bat. \r\n3D Ropecoil Composite Tech Barrell\r\nPower Boost Soft Knob','1732241186.jpg',149.99,'Baseball','49','baseball-bat','2024-11-22 10:06:26','2024-11-22 10:06:26'),(11,'Baseball','Full-grain leather baseball for excellent durability\r\nCompetition grade\r\nRaised red seams for improved grip and control','1732243515.jpg',7.99,'Baseball','100','baseball','2024-11-22 10:45:15','2024-11-22 10:45:15'),(12,'Boxing Gloves','Versatile gloves for MMA, boxing, cardio boxing, and kickboxing enthusiasts. Lightweight with high-quality PU and polyester lining. Mesh palm ensures optimal ventilation, keeping hands cool and dry during intense workouts.\r\nSecure Fit: Self-gripping band ensures a snug fit, providing stability and support','1732243693.webp',34.99,'Boxing','28','boxing-gloves','2024-11-22 10:48:13','2024-11-22 10:48:13'),(13,'Punching Bag','This elite punching bag is perfect for training.\r\nConstructed for durability and longevity.','1732243837.webp',79.99,'Boxing','22','punching-bag','2024-11-22 10:50:37','2024-11-22 10:50:37'),(14,'Row Machine','Simulate the motion of rowing a boat!\r\nThis machine provides:\r\nFull-body workout: Works major muscle groups in the legs, core, arms, and back.\r\nCardiovascular fitness: Excellent for improving aerobic capacity and endurance.','1732243999.webp',199.99,'Home Gym Equipment','19','row-machine','2024-11-22 10:53:19','2024-11-22 10:53:19'),(15,'Home Exercise Bike','Enjoy the cycling experience in the comfort of your own home.\r\n26lb flywheel group, stable and smooth riding reduces the impact on the knees.','1732244192.jpg',399.99,'Home Gym Equipment','11','home-exercise-bike','2024-11-22 10:56:32','2024-11-22 10:56:32'),(16,'Elliptical','Experience immersive trainer-led workouts around the globe on our newest elliptical. (includes the training workouts)\r\nThis State-of-the-art elliptical comes equipped with a 7in. Smart HD Touchscreen and auto-adjusting resistance.','1732244551.webp',1399.99,'Home Gym Equipment','18','elliptical','2024-11-22 11:02:31','2024-11-22 11:02:31'),(17,'Skierg','The SkiErg turns the athlete’s orientation vertical, simulating the movements of real cross-country skiing with both double-pole and classic alternating arm technique. These movements offer one of the most challenging strength and endurance tests available in a fitness machine, targeting the legs, arms, and core for a full body workout adaptable to any athlete’s size and skill level.','1732244702.jpg',650.00,'Home Gym Equipment','16','skierg','2024-11-22 11:05:02','2024-11-22 11:05:02'),(18,'Speed Rope','Built with a 6\" rotating handle for sure grip, this rope is capable of unbeatable speed. The bearing system allows for top-end revolutions, and the coated cable adds speed and durability.','1732244814.webp',25.00,'Crossfit','33','speed-rope','2024-11-22 11:06:54','2024-11-22 11:06:54'),(19,'Weighted Vest','Constructed with front and back padded pockets that each hold up to 20 lbs. The built-in retention straps and velcro flap closure keep weight secure during intense workouts.','1732244951.jpg',109.99,'Crossfit','24','weighted-vest','2024-11-22 11:09:11','2024-11-22 11:09:11'),(20,'Headlamp','Powered with three AAA Alkaline cells (included) or the rechargeable BD 1500 Lithium-Ion battery and charger (sold separately) for maximum flexibility\r\nRed LED night vision has dimming and strobe modes and is quickly activated with a dual-button interface\r\nSettings include dimming, red night-vision, and lock mode','1732245089.webp',32.99,'Climbing','37','headlamp','2024-11-22 11:11:29','2024-11-22 11:11:29'),(21,'Foam Roller','This is a massaging roller that reliably holds its shape and delivers consistent, deep-tissue therapy— helping athletes recover faster and get back in the gym sooner.','1732245803.png',18.00,'Rehabilitation','42','foam-roller','2024-11-22 11:23:23','2024-11-22 11:23:23'),(22,'Snow Tube','The 40\" hard shell puncture-resistant base and our commercial grade DuraTube defend against debris, such as rocks and branches\r\nSlicker bottom provides a faster, smoother sledding experience in various snow conditions; Great for smaller hills and easier to tow on flat terrain','1732245892.webp',199.99,'Snow Sports','26','snow-tube','2024-11-22 11:24:52','2024-11-22 11:24:52'),(23,'Skis','The confidence-boosting control of our Drive Tip design works with the sidecut for smooth turn initiation and a controlled finish to each turn. A sustainable wood core adds stability through a wide range of conditions.','1732245987.webp',267.99,'Snow Sports','15','skis','2024-11-22 11:26:27','2024-11-22 11:26:27'),(24,'Snow Goggles','Perfect for skiing, snowboarding, and other snow sports.\r\nA medium-sized fit frame is compatible with most helmets, while a 40mm wide adjustable strap provides a comfortable and snug fit for all-day wear.\r\nFeatures an expanded lens volume for optimized peripheral vision','1732246098.jpg',44.99,'Snow Sports','27','snow-goggles','2024-11-22 11:28:18','2024-11-22 11:28:18');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('vHvBy6tsxqBw2BRuaUuf4VTFzN9OjfoweMVqnkHm',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoicDRnRnU0TWFkNWgxblRpWWR3TElWMktOcmNEcG5Fa3NIWmxyNWVneCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyOToiaHR0cDovL2xvY2FsaG9zdDo4MDAwL3Byb2ZpbGUiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMToiaHR0cDovL2xvY2FsaG9zdDo4MDAwIjt9czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e319',1732560951);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `usertype` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'User10','user@example.com','user','(313)456-7891','12345 five st, northridge, ca 91301',NULL,'$2y$12$L3gKM6HAorDwvscWdAP1GOE6lzOBZbcwzq32MEcBse3LOsxqDzbXC',NULL,'2024-10-30 15:38:26','2024-11-12 09:21:49'),(2,'admin','admin@example.com','admin','','',NULL,'$2y$12$HGM/z9iGbxnD5q7QRusek.tmvuDhvmxxgcXglJ4IsS40hJKnShzv2',NULL,'2024-10-30 15:39:19','2024-10-30 15:39:19'),(6,'user3','user3@example.com','user','(555)862-7788','44520 Jacobs St, Jupiter, CA 90210',NULL,'$2y$12$qr7.wV1X5tutdv2UaG15Tem.CMr21m5aiP0PBCI.HFjD12OHZyMmq',NULL,'2024-11-11 18:33:46','2024-11-11 18:33:46'),(7,'John Doe','john.doe@example.com','user','(555)123-4567','123 Main St, Springfield, IL 62704',NULL,'$2y$12$yy9MBv3UDIdEKPxDO1BQG.HlVWgelYzD1NAF2.8e3n.zjRCMKb0Nu',NULL,'2024-11-23 04:13:08','2024-11-23 04:13:08'),(8,'Alice Smith','alice.smith@example.com','user','(555)234-5678','456 Oak St, Metropolis, IL 62960',NULL,'$2y$12$SckWSHzxvc8mndxPKIR5wexf.yoGwl1EF.X6M8On1o8sEuPmOP/Zy',NULL,'2024-11-23 04:16:11','2024-11-23 16:11:28'),(9,'Bob Johnson','bob.johnson@example.com','user','(555)345-6789','789 Pine St, Smallville, KS 67524',NULL,'$2y$12$CaeX95dowI1cUfDxG9lhU.HciN49ws3mafvZYnaakckeuJh73whLO',NULL,'2024-11-23 04:18:41','2024-11-23 04:18:41'),(10,'Charlie Brown','charlie.brown@example.com','user','(555)456-7890','101 Maple St, Gotham, NY 10001',NULL,'$2y$12$t1H0T9i9xxNOLP8QRytH1.DKTzXYvXxqAeGkIF3PjOZKORwpvVm8y',NULL,'2024-11-23 04:23:16','2024-11-23 04:23:16');
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

-- Dump completed on 2024-11-25 11:38:04
