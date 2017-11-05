-- MySQL dump 10.13  Distrib 5.7.20, for Linux (x86_64)
--
-- Host: localhost    Database: inventario
-- ------------------------------------------------------
-- Server version	5.7.20-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,'admin','62ec65bac0a0db4d6f94611eb7ec5a02','User','Admin',1,'2017-10-09 10:35:40');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product` int(11) NOT NULL,
  `in` int(11) NOT NULL DEFAULT '0',
  `out` int(11) NOT NULL DEFAULT '0',
  `current_quantity` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_inventory_product_idx` (`product`),
  CONSTRAINT `fk_inventory_product` FOREIGN KEY (`product`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory`
--

LOCK TABLES `inventory` WRITE;
/*!40000 ALTER TABLE `inventory` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `inventory_report`
--

DROP TABLE IF EXISTS `inventory_report`;
/*!50001 DROP VIEW IF EXISTS `inventory_report`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `inventory_report` AS SELECT 
 1 AS `product`,
 1 AS `year_week`,
 1 AS `day_of_week`,
 1 AS `outs`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `product_type` int(11) NOT NULL,
  `current_quantity` int(11) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  `modifier` int(11) NOT NULL,
  `deleted` int(11) DEFAULT '0',
  `deleter` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_products_type_idx` (`product_type`),
  CONSTRAINT `fk_products_type` FOREIGN KEY (`product_type`) REFERENCES `types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'DYC',1,0,1509925721,1,1509925721,1,0,0),(2,'DYC 8',1,0,1509925721,1,1509925721,1,0,0),(3,'J&B',1,0,1509925721,1,1509925721,1,0,0),(4,'CUTTY SARK',1,0,1509925721,1,1509925721,1,0,0),(5,'WHITE LABEL',1,0,1509925721,1,1509925721,1,0,0),(6,'PASSPORT',1,0,1509925721,1,1509925721,1,0,0),(7,'JOHNIE WALKER E. ROJA',1,0,1509925721,1,1509925721,1,0,0),(8,'JOHNIE WALKER E. NEGRA',1,0,1509925721,1,1509925721,1,0,0),(9,'JAMESON ',1,0,1509925721,1,1509925721,1,0,0),(10,'BALLANTINES',1,0,1509925721,1,1509925721,1,0,0),(11,'FOUR ROSES',1,0,1509925721,1,1509925721,1,0,0),(12,'JIM BEAN',1,0,1509925721,1,1509925721,1,0,0),(13,'CARDHU',1,0,1509925721,1,1509925721,1,0,0),(14,'BRUGAL',2,0,1509925721,1,1509925721,1,0,0),(15,'AREHUCAS',2,0,1509925721,1,1509925721,1,0,0),(16,'PAMPERO',2,0,1509925721,1,1509925721,1,0,0),(17,'CACIQUE',2,0,1509925721,1,1509925721,1,0,0),(18,'CACIQUE 500',2,0,1509925721,1,1509925721,1,0,0),(19,'MATUSALEM',2,0,1509925721,1,1509925721,1,0,0),(20,'CAPITAN MORGAN',2,0,1509925721,1,1509925721,1,0,0),(21,'HAVANA 3',2,0,1509925721,1,1509925721,1,0,0),(22,'HAVANA 7',2,0,1509925721,1,1509925721,1,0,0),(23,'BACARDI',2,0,1509925721,1,1509925721,1,0,0),(24,'BACARDI LIMON',2,0,1509925721,1,1509925721,1,0,0),(25,'LEGENDARIO DORADO',2,0,1509925721,1,1509925721,1,0,0),(26,'LEGENDARIO ELIXIR',2,0,1509925721,1,1509925721,1,0,0),(27,'RON MIEL GUANCHE',2,0,1509925721,1,1509925721,1,0,0),(28,'BARCELO',2,0,1509925721,1,1509925721,1,0,0),(29,'SANTA TERESA',2,0,1509925721,1,1509925721,1,0,0),(30,'ABSOLUT',3,0,1509925721,1,1509925721,1,0,0),(31,'ERISTOFF',3,0,1509925721,1,1509925721,1,0,0),(32,'ERISTOFF BLACK',3,0,1509925721,1,1509925721,1,0,0),(33,'SMIRNOFF',3,0,1509925721,1,1509925721,1,0,0),(34,'BEEFEATER',4,0,1509925721,1,1509925721,1,0,0),(35,'BOMBAY',4,0,1509925721,1,1509925721,1,0,0),(36,'BOMBAY SHAPIRE',4,0,1509925721,1,1509925721,1,0,0),(37,'TANQUERAY',4,0,1509925721,1,1509925721,1,0,0),(38,'SEAGRAMS',4,0,1509925721,1,1509925721,1,0,0),(39,'LARIOS',4,0,1509925721,1,1509925721,1,0,0),(40,'LARIOS 12 ',4,0,1509925721,1,1509925721,1,0,0),(41,'LARIOS ROSÉ',4,0,1509925721,1,1509925721,1,0,0),(42,'PUERTO DE INDIAS',4,0,1509925721,1,1509925721,1,0,0),(43,'CITADELLE',4,0,1509925721,1,1509925721,1,0,0),(44,'BULL DOG',4,0,1509925721,1,1509925721,1,0,0),(45,'GINEBRA NORDES',4,0,1509925721,1,1509925721,1,0,0),(46,'G. WINE FLORAISON',4,0,1509925721,1,1509925721,1,0,0),(47,'GINEBRA BROOKMANS',4,0,1509925721,1,1509925721,1,0,0),(48,'GINEBRA HENDRICKS',4,0,1509925721,1,1509925721,1,0,0),(49,'GINEBRA MARTIN MILLERS',4,0,1509925721,1,1509925721,1,0,0),(50,'MALIBU',5,0,1509925721,1,1509925721,1,0,0),(51,'BAYLEIS',5,0,1509925721,1,1509925721,1,0,0),(52,'PONCHE CABALLERO',5,0,1509925721,1,1509925721,1,0,0),(53,'LICOR 43',5,0,1509925721,1,1509925721,1,0,0),(54,'MARTINI BLANCO',5,0,1509925721,1,1509925721,1,0,0),(55,'MARTINI ROJO',5,0,1509925721,1,1509925721,1,0,0),(56,'COINTREAU',5,0,1509925721,1,1509925721,1,0,0),(57,'LIMA',5,0,1509925721,1,1509925721,1,0,0),(58,'KIWI',5,0,1509925721,1,1509925721,1,0,0),(59,'GRANADINA',5,0,1509925721,1,1509925721,1,0,0),(60,'BLUE TROPIC',5,0,1509925721,1,1509925721,1,0,0),(61,'BATIDA DE COCO',5,0,1509925721,1,1509925721,1,0,0),(62,'LICOR DE MELOCOTÓN',5,0,1509925721,1,1509925721,1,0,0),(63,'LICOR DE MANZANA',5,0,1509925721,1,1509925721,1,0,0),(64,'MELOCOTON SIN',5,0,1509925721,1,1509925721,1,0,0),(65,'MANZANA SIN',5,0,1509925721,1,1509925721,1,0,0),(66,'PACHARÁN ',5,0,1509925721,1,1509925721,1,0,0),(67,'TEQUILA',5,0,1509925721,1,1509925721,1,0,0),(68,'JOSE CUERVO',5,0,1509925721,1,1509925721,1,0,0),(69,'TIA MARIA',5,0,1509925721,1,1509925721,1,0,0),(70,'FRANGELICO',5,0,1509925721,1,1509925721,1,0,0),(71,'DISARONNO',5,0,1509925721,1,1509925721,1,0,0),(72,'SOBERANO',5,0,1509925721,1,1509925721,1,0,0),(73,'ORANGEAU',5,0,1509925721,1,1509925721,1,0,0),(74,'LICOR HIERBAS',5,0,1509925721,1,1509925721,1,0,0),(75,'CREMA DE ORUJO',5,0,1509925721,1,1509925721,1,0,0),(76,'LICOR DE CAFÉ',5,0,1509925721,1,1509925721,1,0,0),(77,'JAGGERMAIFFER',5,0,1509925721,1,1509925721,1,0,0);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `types`
--

DROP TABLE IF EXISTS `types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `family` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `types`
--

LOCK TABLES `types` WRITE;
/*!40000 ALTER TABLE `types` DISABLE KEYS */;
INSERT INTO `types` VALUES (1,'product_type','WHISKY'),(2,'product_type','RON'),(3,'product_type','VODKA'),(4,'product_type','GINEBRA'),(5,'product_type','VARIOS');
/*!40000 ALTER TABLE `types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `inventory_report`
--

/*!50001 DROP VIEW IF EXISTS `inventory_report`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `inventory_report` AS select `p`.`id` AS `product`,date_format(from_unixtime(`i`.`created`),'%Y %U') AS `year_week`,date_format(from_unixtime(`i`.`created`),'%w') AS `day_of_week`,sum(`i`.`out`) AS `outs` from (`products` `p` join `inventory` `i` on((`i`.`product` = `p`.`id`))) group by `i`.`product`,`year_week`,`day_of_week` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-11-05 18:50:40
