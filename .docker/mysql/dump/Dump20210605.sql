-- MySQL dump 10.13  Distrib 8.0.22, for Win64 (x86_64)
--
-- Host: 52.73.11.95    Database: lumen
-- ------------------------------------------------------
-- Server version	5.7.34-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `apis`
--

DROP TABLE IF EXISTS `apis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `api` varchar(255) NOT NULL,
  `fields` json NOT NULL,
  `page_id` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  CONSTRAINT `apis_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apis`
--

LOCK TABLES `apis` WRITE;
/*!40000 ALTER TABLE `apis` DISABLE KEYS */;
INSERT INTO `apis` VALUES (8,'static-page','[{\"name\": \"nome\", \"type\": {\"code\": \"string\", \"name\": \"Texto\"}, \"description\": \"\"}, {\"name\": \"email\", \"type\": {\"code\": \"string\", \"name\": \"Texto\"}, \"description\": \"\"}, {\"name\": \"telefone\", \"type\": {\"code\": \"string\", \"name\": \"Texto\"}, \"description\": \"\"}, {\"name\": \"mensagem\", \"type\": {\"code\": \"string\", \"name\": \"Texto\"}, \"description\": \"\"}, {\"name\": \"aceito_wpp\", \"type\": {\"code\": \"boolean\", \"name\": \"Checkbox\"}, \"description\": \"\"}, {\"name\": \"aceito_email\", \"type\": {\"code\": \"boolean\", \"name\": \"Checkbox\"}, \"description\": \"\"}, {\"name\": \"termo\", \"type\": {\"code\": \"boolean\", \"name\": \"Checkbox\"}, \"description\": \"\"}]',1,1,'2021-06-04 19:45:16','2021-06-04 19:43:52');
/*!40000 ALTER TABLE `apis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `comment` longtext NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,1,'TEASTE','2021-05-18 20:45:07','2021-05-18 20:45:07'),(2,1,'test','2021-05-18 20:47:45','2021-05-18 20:47:45'),(3,1,'test','2021-05-18 20:48:21','2021-05-18 20:48:21'),(4,1,'test','2021-05-18 20:49:26','2021-05-18 20:49:26'),(5,1,'test','2021-05-18 20:52:11','2021-05-18 20:52:11'),(6,1,'test','2021-05-18 20:52:25','2021-05-18 20:52:25'),(7,1,'test','2021-05-18 20:52:36','2021-05-18 20:52:36'),(8,1,'wdadwa','2021-05-18 20:53:02','2021-05-18 20:53:02'),(9,1,'Hoje tem','2021-05-18 20:53:06','2021-05-18 20:53:06'),(10,1,'Hoje tem TESTE TESTHoje tem TESTE TESTHoje tem TESTE TESTHoje tem TESTE TESTHoje tem TESTE TESTHoje tem TESTE TEST','2021-05-18 20:53:15','2021-05-18 20:53:15'),(11,1,'ab ','2021-05-18 20:58:39','2021-05-18 20:58:39'),(12,1,'Mensagem Teste','2021-05-28 00:28:05','2021-05-28 00:28:05'),(13,1,'Outra Mensagem','2021-05-28 00:28:10','2021-05-28 00:28:10');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `keywords`
--

DROP TABLE IF EXISTS `keywords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `keywords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `keywords`
--

LOCK TABLES `keywords` WRITE;
/*!40000 ALTER TABLE `keywords` DISABLE KEYS */;
/*!40000 ALTER TABLE `keywords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leads`
--

DROP TABLE IF EXISTS `leads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `leads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `priority_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `api_id` int(11) DEFAULT NULL,
  `data` json DEFAULT NULL,
  `origem` varchar(45) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_LEADS_PAGINA1_idx` (`page_id`),
  KEY `fk_LEAD_STATUS1_idx` (`status_id`),
  KEY `fk_leads_users1_idx` (`user_id`),
  KEY `fk_leads_priorities1_idx` (`priority_id`),
  KEY `api_id` (`api_id`),
  CONSTRAINT `fk_LEADS_PAGINA1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_LEAD_STATUS1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_leads_priorities1` FOREIGN KEY (`priority_id`) REFERENCES `priorities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_leads_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `leads_ibfk_1` FOREIGN KEY (`api_id`) REFERENCES `apis` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leads`
--

LOCK TABLES `leads` WRITE;
/*!40000 ALTER TABLE `leads` DISABLE KEYS */;
INSERT INTO `leads` VALUES (73,1,1,1,1,8,'{\"nome\": \"dwa\", \"email\": \"dwa\", \"termo\": \"0\", \"mensagem\": \"tesadwdwa\", \"telefone\": \"21231\", \"aceito_wpp\": \"1\", \"aceito_email\": \"1\"}',NULL,'2021-06-04 21:09:14','2021-06-04 21:09:14');
/*!40000 ALTER TABLE `leads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leads_comments`
--

DROP TABLE IF EXISTS `leads_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `leads_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lead_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lead_id` (`lead_id`),
  KEY `comment_id` (`comment_id`),
  CONSTRAINT `leads_comments_ibfk_2` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`),
  CONSTRAINT `leads_comments_ibfk_3` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leads_comments`
--

LOCK TABLES `leads_comments` WRITE;
/*!40000 ALTER TABLE `leads_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `leads_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `models`
--

DROP TABLE IF EXISTS `models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `models` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_id` int(11) NOT NULL,
  `model` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_MODELO_FABRICANTE1_idx` (`brand_id`),
  CONSTRAINT `fk_MODELO_FABRICANTE1` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `models`
--

LOCK TABLES `models` WRITE;
/*!40000 ALTER TABLE `models` DISABLE KEYS */;
/*!40000 ALTER TABLE `models` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `site` varchar(45) DEFAULT NULL,
  `epic` varchar(45) DEFAULT NULL,
  `token` varchar(45) NOT NULL,
  `refer` varchar(45) DEFAULT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_UNIQUE` (`site`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,'Gabriel Ulbrich','gabrielulbrich.com.br','gabrielulbrich','token123','gabrielulbrich.com.br',NULL),(2,'Teste Page','site.com.br','site','token123','site.com.br',NULL);
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `priorities`
--

DROP TABLE IF EXISTS `priorities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `priorities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `priority` varchar(45) DEFAULT NULL,
  `icon_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `priorities`
--

LOCK TABLES `priorities` WRITE;
/*!40000 ALTER TABLE `priorities` DISABLE KEYS */;
INSERT INTO `priorities` VALUES (1,'Baixa','https://jira.uhub.biz/images/icons/priorities/low.svg'),(2,'Media','https://jira.uhub.biz/images/icons/priorities/medium.svg'),(3,'Alta','https://jira.uhub.biz/images/icons/priorities/high.svg'),(4,'Muito Alta','https://jira.uhub.biz/images/icons/priorities/highest.svg');
/*!40000 ALTER TABLE `priorities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `preco` decimal(3,2) DEFAULT NULL,
  `ano` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_PRODUTO_PAGINA1_idx` (`page_id`),
  KEY `fk_PRODUTO_MODELO1_idx` (`model_id`),
  CONSTRAINT `fk_PRODUTO_MODELO1` FOREIGN KEY (`model_id`) REFERENCES `models` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_PRODUTO_PAGINA1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products_shops`
--

DROP TABLE IF EXISTS `products_shops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_shops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`product_id`,`shop_id`),
  KEY `fk_PRODUTO_LOJA_PRODUTO1_idx` (`product_id`),
  KEY `fk_PRODUTO_LOJA_LOJA1_idx` (`shop_id`),
  CONSTRAINT `fk_PRODUTO_LOJA_LOJA1` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_PRODUTO_LOJA_PRODUTO1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products_shops`
--

LOCK TABLES `products_shops` WRITE;
/*!40000 ALTER TABLE `products_shops` DISABLE KEYS */;
/*!40000 ALTER TABLE `products_shops` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profile` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profiles`
--

LOCK TABLES `profiles` WRITE;
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
INSERT INTO `profiles` VALUES (1,'Administrador'),(2,'Usuário'),(3,'Em Aprovação'),(4,'Inativo'),(5,'Master');
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shops`
--

DROP TABLE IF EXISTS `shops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `uf` varchar(45) NOT NULL,
  `cidade` varchar(45) NOT NULL,
  `rua` varchar(45) NOT NULL,
  `numero` varchar(45) NOT NULL,
  `cep` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shops`
--

LOCK TABLES `shops` WRITE;
/*!40000 ALTER TABLE `shops` DISABLE KEYS */;
/*!40000 ALTER TABLE `shops` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` VALUES (1,'Aberto'),(2,'Em Progresso'),(3,'Bloqueado'),(4,'Finalizado');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `cpf` varchar(45) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `avatar_url` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `CPF_UNIQUE` (`cpf`),
  UNIQUE KEY `EMAIL_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Gabriel','gabriel.u10@hotmail.com','10396460933','$2y$10$hQut50gdBA.4pgSUS3WKou5Y/kDCjiIDIJkRDMKQRl27/RRtmXb.m','/assets/user_icons/girl.png','2020-10-30 00:04:52','2020-10-04 19:56:05'),(6,'Ninguém','unasigned@example.com','000.000.000-00','$2y$10$btCyW59qJhLUqNT0CfFq4enPFpElRYnSM9gLISKO99s/THrYfVViO','/assets/user_icons/default-avatar.png','2020-10-07 01:37:20','2020-10-07 01:37:20'),(8,'Gabriel 2','teste@example.com','103.964.609-332','$2y$10$ohVm5BRskbDfC23cjY2CAehle0n9I5OsAk.Zv.33CpR8HFJ5bAb9u','/assets/user_icons/man-2.png','2020-10-07 01:38:12','2020-10-07 01:38:12'),(10,'Gabriel 3','testeuu@example.com','103.964.609-31','$2y$10$gxT3UbBp/kKticKG0zhPaekFo0kkU83nNsIUzMX.e.5lWHYU7HN/6','/assets/user_icons/man-4.png','2020-10-16 01:10:29','2020-10-16 01:10:29'),(13,'Gabriel','teste1@example.com','421','$2y$10$iQJiLXuJzzuc1ZaQvu5oF.JVgXPHwPufcJ3NSh8Sq6il5TL6prOpy','/assets/user_icons/avatar.png','2020-10-30 00:12:43','2020-10-30 00:12:43'),(14,'Gabriel Ulbrich de Souza','gabriel@gabriel.com','10396460222','$2y$10$4AMByQ2gXYrNuZuN7LlDweFxB.x5Xu72eWelb2c/Y1S7SfkA2g9xu','/assets/user_icons/avatar.png','2020-10-30 00:37:35','2020-10-30 00:37:35'),(15,'Test','gabriel1@hotmail.com','103','$2y$10$jpAOsoxSdrFdaPazcIgjvuC8BiM7xTVj4D4g9UidOiiOD7TmKsgV2','/assets/user_icons/avatar.png','2020-10-30 00:44:34','2020-10-30 00:44:34'),(16,'Test','gabriel2@hotmail.com','1321321','$2y$10$/YH2WUMYyPDziQfV6lfz6OAkAyZXgmKzu04XGuxZ1/SEqM3BWfmcK','/assets/user_icons/user.png','2020-10-30 00:46:46','2020-10-30 00:46:46'),(17,'Gabriel Ulbrich de Souza','gabriel3@hotmail.com','1039646421','$2y$10$3EruACeF.N8cR6havH4y8O4DTLreMALVD.itcZxVkGjsFI0G1mASy','/assets/user_icons/user.png','2020-10-30 00:53:22','2020-10-30 00:53:22'),(18,'ts','ts@tsad.com','241421','$2y$10$4x2puQL7e/3K1cfjlq5jEuzLZKPj7jttOUAnq0tqu4ssOdwfogk22','/assets/user_icons/user.png','2020-11-01 00:08:37','2020-11-01 00:08:37'),(19,'abc','teste123@hotmail.com','23323','$2y$10$fMOAgYNq/iM0CKPUTl6lk.1bzMySFw.enclfXZQRw6fpp5onarIEq','/assets/user_icons/user.png','2020-11-01 00:11:43','2020-11-01 00:11:43'),(20,'abwdwawd','awdwa@hotmail.com','2132231','$2y$10$qyVL0F6bSBMr8DsbyUxITu1h2sx55PVrBBjaKe1vChl/salT.Hnzi','/assets/user_icons/user.png','2020-11-01 00:14:46','2020-11-01 00:14:46'),(21,'abc123','awdwa3@hotmail.com','213223123','$2y$10$ofF0aA1eMkS5M8AxxtaScOVW2TKF123tDtOu2ue3.g5Ewc1nlt/6.','/assets/user_icons/user.png','2020-11-01 00:16:52','2020-11-01 00:16:52'),(22,'Gabriel','testee1@hotmail.com','1','$2y$10$5HSZKkoTXwu7MT5uk0kxIu0FSLaz9XqIO0CvxFaLoN51suflMJ2My','/assets/user_icons/user.png','2020-11-01 00:39:21','2020-11-01 00:39:21'),(23,'Gabriel','testee12@hotmail.com','12','$2y$10$Ag6hR.ix39BvO/5jPEZXBOpRHhazi6/QUUaA6UYHHxCbS0dCAzV22','/assets/user_icons/user.png','2020-11-01 00:39:47','2020-11-01 00:39:47'),(24,'Gabriel','testee123@hotmail.com','123','$2y$10$gcfry9wr6XPYvIWQmfRS3.e6DXJuhqkKM1tHuJjBPGvOMh5ZcGHG2','/assets/user_icons/user.png','2020-11-01 00:40:26','2020-11-01 00:40:26'),(25,'Gabriel','teste5@test.com','103.964.609-99','$2y$10$L.EQBjOtswZmM4OgCssCu.gQuluuqtNiRa0RLoBccwKnoahZSc0Q.','/assets/user_icons/user.png','2021-04-07 21:18:33','2021-04-07 21:18:33'),(26,'Gabriel','teste55@test.com','103.964.609-92','$2y$10$RA.tzo5scW4.SzrMPBvWYuJMJJC..mgYELm0hmgwExjhexoOP9OVG','/assets/user_icons/user.png','2021-04-07 21:32:03','2021-04-07 21:32:03'),(27,'Gabriel','teste6@test.com','103.964.609-93','$2y$10$sqq9wZkMemNQOqWXM1ZGpuPCexfeVZmvG3tElvMhdX3UXhppz9FZC','/assets/user_icons/user.png','2021-04-07 21:33:01','2021-04-07 21:33:01'),(28,'Gabriel','test4@test.com','103.964.609-94','$2y$10$XPIUKhjFv9QniJNdVF.WreKl0Ka56UmaXT4ZrYvBgrgYjc5Pc6o12','/assets/user_icons/user.png','2021-04-07 21:37:38','2021-04-07 21:37:38'),(29,'Gabriel','test5@test.com','103.964.609-95','$2y$10$MN0K4BgxP.iPzAdGdvSowO2hNfd7vLrEr0/Yqf3b0F3LQliYRJHX6','/assets/user_icons/user.png','2021-04-07 21:43:04','2021-04-07 21:43:04'),(30,'Gabriel','test1234@hotmail.com','103.964.069-03','$2y$10$CCG6k8Gtg4LqZ8m6Qu5FHO7c9PNVmu0E824qnnHbv4oW1gVsaINSe','/assets/user_icons/user.png','2021-04-07 21:52:17','2021-04-07 21:52:17'),(31,'HDUIOWAHIUDwa','djoiwa@hotmail.com','102.390.123-09','$2y$10$rShv/LLHGYNJBj7iYkT2iuYLZeL45xidzRnNx68jNy5ILiVBgc0lu','/assets/user_icons/user.png','2021-04-07 21:53:19','2021-04-07 21:53:19'),(32,'dawdwadwa','odiwuahygguiy@hotmail.com','120.938.129-03','$2y$10$FLKS5cQhIzDmrgJOI4WX9uC9mh36jTswfOox3VUIaxC012vvq47wK','/assets/user_icons/user.png','2021-04-07 21:55:10','2021-04-07 21:55:10'),(34,'Gabriel','gabriel.u120@hotmail.com','10396460932','$2y$10$hQut50gdBA.4pgSUS3WKou5Y/kDCjiIDIJkRDMKQRl27/RRtmXb.m','/assets/user_icons/girl.png','2020-10-30 00:04:52','2020-10-04 19:56:05');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_pages`
--

DROP TABLE IF EXISTS `users_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users_pages` (
  `user_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`page_id`),
  KEY `fk_USUARIO_PAGINA_USUARIO1_idx` (`user_id`),
  KEY `fk_USUARIO_PAGINA_PAGINA1_idx` (`page_id`),
  KEY `fk_users_pages_profiles1_idx` (`profile_id`),
  CONSTRAINT `fk_USUARIO_PAGINA_PAGINA1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_USUARIO_PAGINA_USUARIO1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_pages_profiles1` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_pages`
--

LOCK TABLES `users_pages` WRITE;
/*!40000 ALTER TABLE `users_pages` DISABLE KEYS */;
INSERT INTO `users_pages` VALUES (1,1,1),(8,2,1),(32,1,1),(22,1,2),(29,2,2),(30,2,2),(32,2,2),(23,1,3),(24,1,3),(21,1,4),(31,2,4);
/*!40000 ALTER TABLE `users_pages` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-06-05 12:40:14
