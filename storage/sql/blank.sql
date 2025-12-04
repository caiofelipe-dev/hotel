CREATE DATABASE  IF NOT EXISTS `hotel` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `hotel`;
-- MySQL dump 10.13  Distrib 8.0.44, for Win64 (x86_64)
--
-- Host: localhost    Database: hotel
-- ------------------------------------------------------
-- Server version	8.0.44

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
-- Table structure for table `adicionais_tipos`
--

DROP TABLE IF EXISTS `adicionais_tipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `adicionais_tipos` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `descricao` varchar(100) NOT NULL,
  `icone` varchar(100) DEFAULT NULL,
  `valor_referencia` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adicionais_tipos`
--

LOCK TABLES `adicionais_tipos` WRITE;
/*!40000 ALTER TABLE `adicionais_tipos` DISABLE KEYS */;
/*!40000 ALTER TABLE `adicionais_tipos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quartos`
--

DROP TABLE IF EXISTS `quartos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quartos` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `descricao` varchar(100) NOT NULL,
  `preco_diaria` decimal(10,2) NOT NULL,
  `qtd_camas_casal` tinyint unsigned DEFAULT '0',
  `qtd_camas_solteiro` tinyint unsigned DEFAULT '0',
  `max_camas_casal` tinyint unsigned DEFAULT '0',
  `max_camas_solteiro` tinyint unsigned DEFAULT '0',
  `tem_ventilador` tinyint(1) DEFAULT '0',
  `tem_ar_condicionado` tinyint(1) DEFAULT '0',
  `tem_agua_quente` tinyint(1) DEFAULT '0',
  `tem_banheira` tinyint(1) DEFAULT '0',
  `tem_wifi` tinyint(1) DEFAULT '0',
  `tem_frigobar` tinyint(1) DEFAULT '0',
  `tem_tv` tinyint(1) DEFAULT '0',
  `e_friendly_pet` tinyint(1) DEFAULT '0',
  `e_acessivel` tinyint(1) DEFAULT '0',
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quartos`
--

LOCK TABLES `quartos` WRITE;
/*!40000 ALTER TABLE `quartos` DISABLE KEYS */;
/*!40000 ALTER TABLE `quartos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quartos_adicionais`
--

DROP TABLE IF EXISTS `quartos_adicionais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quartos_adicionais` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `quartos_id` bigint NOT NULL,
  `adicionais_tipos_id` bigint NOT NULL,
  `qtd_min` tinyint unsigned DEFAULT '0',
  `qtd_max` tinyint unsigned DEFAULT '1',
  `valor_cobrado` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quartos_id` (`quartos_id`),
  KEY `adicionais_tipos_id` (`adicionais_tipos_id`),
  CONSTRAINT `quartos_adicionais_ibfk_1` FOREIGN KEY (`quartos_id`) REFERENCES `quartos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `quartos_adicionais_ibfk_2` FOREIGN KEY (`adicionais_tipos_id`) REFERENCES `adicionais_tipos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quartos_adicionais`
--

LOCK TABLES `quartos_adicionais` WRITE;
/*!40000 ALTER TABLE `quartos_adicionais` DISABLE KEYS */;
/*!40000 ALTER TABLE `quartos_adicionais` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-04 15:37:31
