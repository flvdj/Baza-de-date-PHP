CREATE DATABASE  IF NOT EXISTS `cfr` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `cfr`;
-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: cfr
-- ------------------------------------------------------
-- Server version	9.1.0

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
-- Table structure for table `branchcfr`
--

DROP TABLE IF EXISTS `branchcfr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `branchcfr` (
  `idbranchcfr` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` bigint DEFAULT NULL,
  `site` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idbranchcfr`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `branchcfr`
--

LOCK TABLES `branchcfr` WRITE;
/*!40000 ALTER TABLE `branchcfr` DISABLE KEYS */;
INSERT INTO `branchcfr` VALUES (9,'cluj1','bucuresti','movileni',34343434,'sjsjsjsj.com'),(11,'leps2','lepsa','lepsaaaaa',731339855,'erere');
/*!40000 ALTER TABLE `branchcfr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journey`
--

DROP TABLE IF EXISTS `journey`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `journey` (
  `idjourney` bigint NOT NULL AUTO_INCREMENT,
  `idbranchcfr` bigint DEFAULT NULL,
  `date` date DEFAULT NULL,
  `hour` bigint DEFAULT NULL,
  `ticket` varchar(255) DEFAULT NULL,
  `clasa` bigint DEFAULT NULL,
  `start` varchar(255) DEFAULT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `id_travellers` bigint DEFAULT NULL,
  PRIMARY KEY (`idjourney`),
  KEY `fk2_idx` (`idbranchcfr`),
  KEY `fk2_idx1` (`id_travellers`),
  CONSTRAINT `fk1` FOREIGN KEY (`idbranchcfr`) REFERENCES `branchcfr` (`idbranchcfr`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk2` FOREIGN KEY (`id_travellers`) REFERENCES `travellers` (`id_travellers`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journey`
--

LOCK TABLES `journey` WRITE;
/*!40000 ALTER TABLE `journey` DISABLE KEYS */;
INSERT INTO `journey` VALUES (8,9,'2002-04-05',12,'wewewe',4,'costinesti','padureaneagra',10),(13,9,'2025-01-24',5,'wewewe',1,'bucuresti','padureaneagra',12),(14,11,'2025-01-31',3,'wewewe',4,'bucuresti','kualalumpur',15);
/*!40000 ALTER TABLE `journey` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `travellers`
--

DROP TABLE IF EXISTS `travellers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `travellers` (
  `id_travellers` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `cnp` bigint DEFAULT NULL,
  `phonenumber` bigint DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_travellers`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `travellers`
--

LOCK TABLES `travellers` WRITE;
/*!40000 ALTER TABLE `travellers` DISABLE KEYS */;
INSERT INTO `travellers` VALUES (10,'Flaviu','ddfdf',758585,838383,'dsdsdsdsd'),(12,'Cosmin','Oprea',3232323,748484,'dambovit'),(15,'antal','putinica',545454,3438483,'lepsa');
/*!40000 ALTER TABLE `travellers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-29 18:23:01
