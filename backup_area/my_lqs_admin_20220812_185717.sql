-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: my_lqs_admin
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

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
-- Table structure for table `favorite_queries`
--

DROP TABLE IF EXISTS `favorite_queries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `favorite_queries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(100) NOT NULL,
  `db` varchar(100) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `btn_name` varchar(20) NOT NULL,
  `query` varchar(1024) NOT NULL,
  `creation_date` date NOT NULL DEFAULT curdate(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favorite_queries`
--

LOCK TABLES `favorite_queries` WRITE;
/*!40000 ALTER TABLE `favorite_queries` DISABLE KEYS */;
/*!40000 ALTER TABLE `favorite_queries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `standard_queries`
--

DROP TABLE IF EXISTS `standard_queries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `standard_queries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(100) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `btn_name` varchar(20) NOT NULL,
  `query` varchar(1024) NOT NULL,
  `creation_date` date NOT NULL DEFAULT curdate(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `standard_queries`
--

LOCK TABLES `standard_queries` WRITE;
/*!40000 ALTER TABLE `standard_queries` DISABLE KEYS */;
INSERT INTO `standard_queries` VALUES (1,'root','Query to list table relations in a DB','TBLS_REL','SELECT TABLE_NAME TBL,COLUMN_NAME COL,CONSTRAINT_NAME IBFK, REFERENCED_TABLE_NAME REF_TBL,REFERENCED_COLUMN_NAME REF_COL FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_SCHEMA = SCHEMA()','2022-07-26'),(2,'root','List of tables pointed to by the selected table','RIGHT_TBL_RELAT','SELECT TABLE_NAME TBL,COLUMN_NAME COL, REFERENCED_TABLE_NAME REF_TBL,REFERENCED_COLUMN_NAME REF_COL FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_SCHEMA = SCHEMA() AND TABLE_NAME = ','2022-07-26'),(3,'root','list tables that point to the selected table','LEFT_TBL_RELAT','SELECT TABLE_NAME TBL,COLUMN_NAME COL, REFERENCED_TABLE_NAME REF_TBL,REFERENCED_COLUMN_NAME REF_COL FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_SCHEMA = SCHEMA() AND REFERENCED_TABLE_NAME = ','2022-07-26'),(4,'root','Tables list of a DB, with their size','TBLS_SIZE','SELECT table_name TBL, round( (data_length / 1024 / 1024) , 2) SIZE_MB FROM information_schema.TABLES WHERE table_schema = SCHEMA()','2022-07-26');
/*!40000 ALTER TABLE `standard_queries` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-08-12 18:57:17
