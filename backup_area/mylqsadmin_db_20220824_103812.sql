-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: mylqsadmin_db
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
-- Table structure for table `estado_usuarios`
--

DROP TABLE IF EXISTS `estado_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estado_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `disable` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado_usuarios`
--

LOCK TABLES `estado_usuarios` WRITE;
/*!40000 ALTER TABLE `estado_usuarios` DISABLE KEYS */;
INSERT INTO `estado_usuarios` VALUES (2,29,1,0),(3,30,1,0),(4,31,1,0),(5,32,1,0);
/*!40000 ALTER TABLE `estado_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf16_spanish_ci NOT NULL,
  `usuario` varchar(100) COLLATE utf16_spanish_ci NOT NULL,
  `email` varchar(100) COLLATE utf16_spanish_ci NOT NULL,
  `password` varchar(256) COLLATE utf16_spanish_ci NOT NULL,
  `token_acceso` varchar(256) COLLATE utf16_spanish_ci DEFAULT NULL,
  `token_fecha` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (29,'Darren','MDMGN','michaelmdvrhack@gmail.com','cbc57730686498d09ef7b65de4d55c5cab8feee048d55a87790b7caa64de1bfd40e79fc63e8665b754fe390cdfac537ba5c1dffb2cc0523bdedafaadd2110ba0','5fb54653ca1d1514a264043252eae2dfe2fc5f089afc144057106d9c725120ca',1655393455),(30,'Darren','MDMGN2','micha@gmail.com','cbc57730686498d09ef7b65de4d55c5cab8feee048d55a87790b7caa64de1bfd40e79fc63e8665b754fe390cdfac537ba5c1dffb2cc0523bdedafaadd2110ba0','51848fd4c5a7e75a66b88a687a2045de614235b727ba454ec3222babd06466aa',1655393674),(31,'Darren','MDMGN3','mich@gmail.com','cbc57730686498d09ef7b65de4d55c5cab8feee048d55a87790b7caa64de1bfd40e79fc63e8665b754fe390cdfac537ba5c1dffb2cc0523bdedafaadd2110ba0','c7c1415332a96eb79daca7477e2079fa89e0100c071396f88d9e18844707651d',1655399105),(32,'iggDarren','iggDarren','igg.git.h@gmail.com','d5b33fa3984a5fac7dac63e646a141e64038dbc46444a62c70f87d38928ba2dff4b718592bfdca19d79b2d82783006dde22263b8ead718b76985a349e89874aa','a40a292e15b053414b93927e9087ce431830990f1dc83c64caaca808b2a3e283',1660817867);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-08-24 10:38:13
