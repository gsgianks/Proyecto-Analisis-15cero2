-- MySQL dump 10.13  Distrib 5.7.12, for linux-glibc2.5 (x86_64)
--
-- Host: localhost    Database: db15cero2
-- ------------------------------------------------------
-- Server version	5.7.16-0ubuntu0.16.04.1

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
-- Dumping data for table `tbarticulo`
--

LOCK TABLES `tbarticulo` WRITE;
/*!40000 ALTER TABLE `tbarticulo` DISABLE KEYS */;
INSERT INTO `tbarticulo` VALUES (26,'ART-123',4,'Alvaro Feliz<3',1234,'b'),(28,'ART-123',4,'Alvaro Feliz<3',123,'m'),(29,'ALV-1',4,'aaaaaaaa',78989,'b'),(30,'ALV-1',4,'Articulo 1',78989,'b');
/*!40000 ALTER TABLE `tbarticulo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `tbbodega`
--

LOCK TABLES `tbbodega` WRITE;
/*!40000 ALTER TABLE `tbbodega` DISABLE KEYS */;
INSERT INTO `tbbodega` VALUES ('ALV-1',2,0),('ART-123',2,0);
/*!40000 ALTER TABLE `tbbodega` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `tbcategoria`
--

LOCK TABLES `tbcategoria` WRITE;
/*!40000 ALTER TABLE `tbcategoria` DISABLE KEYS */;
INSERT INTO `tbcategoria` VALUES (3,'No se',0),(4,'asd',3);
/*!40000 ALTER TABLE `tbcategoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `tbcliente`
--

LOCK TABLES `tbcliente` WRITE;
/*!40000 ALTER TABLE `tbcliente` DISABLE KEYS */;
INSERT INTO `tbcliente` VALUES (39,'Alvaro','varogonz@gmail.com','83583025','Mi casa');
/*!40000 ALTER TABLE `tbcliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `tbeven_art`
--

LOCK TABLES `tbeven_art` WRITE;
/*!40000 ALTER TABLE `tbeven_art` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbeven_art` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `tbevento`
--

LOCK TABLES `tbevento` WRITE;
/*!40000 ALTER TABLE `tbevento` DISABLE KEYS */;
INSERT INTO `tbevento` VALUES (84,'Test','2016-11-26','2016-11-26','Alguna parte',39);
/*!40000 ALTER TABLE `tbevento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `tbfactura`
--

LOCK TABLES `tbfactura` WRITE;
/*!40000 ALTER TABLE `tbfactura` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbfactura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `tblogin`
--

LOCK TABLES `tblogin` WRITE;
/*!40000 ALTER TABLE `tblogin` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblogin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `tbpago`
--

LOCK TABLES `tbpago` WRITE;
/*!40000 ALTER TABLE `tbpago` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbpago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `tbservicios`
--

LOCK TABLES `tbservicios` WRITE;
/*!40000 ALTER TABLE `tbservicios` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbservicios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-26 22:04:23
