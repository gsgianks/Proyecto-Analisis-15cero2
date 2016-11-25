CREATE DATABASE  IF NOT EXISTS `db15cero2` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `db15cero2`;
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
-- Table structure for table `tbarticulo`
--

DROP TABLE IF EXISTS `tbarticulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbarticulo` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Codigo` varchar(10) NOT NULL,
  `Id_Categoria` int(11) NOT NULL,
  `Descripcion` varchar(500) NOT NULL,
  `Precio` double NOT NULL,
  `Estado` char(1) NOT NULL,
  PRIMARY KEY (`Id`,`Codigo`,`Id_Categoria`),
  KEY `Id_Categoria` (`Id_Categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbarticulo`
--

LOCK TABLES `tbarticulo` WRITE;
/*!40000 ALTER TABLE `tbarticulo` DISABLE KEYS */;
INSERT INTO `tbarticulo` VALUES (17,'H123',2,'dasda',123,'b'),(18,'ART-123',2,'Alvaro Feliz<3',1234,'b'),(19,'ART-123',2,'Articulo 1',12345,'r');
/*!40000 ALTER TABLE `tbarticulo` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger after_insert_articulo
after insert
on tbarticulo for each row
begin
if exists(select Codigo from tbbodega where Codigo=NEW.Codigo) then
	update tbbodega set Disponibles = Disponibles + 1 where NEW.Codigo = Codigo;
else
	insert into tbbodega(Codigo, Disponibles) values(NEW.Codigo, 1);
end if;
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger after_delete_articulo
after delete on tbarticulo
for each row
begin
		update tbbodega set Disponibles=Disponibles-1;
        if ((select Reservados from tbbodega where Codigo=OLD.Codigo)!=0) then
			update tbbodega set Reservados=Reservados-1;
        else
			update tbbodega set Reservados=0;
		end if;
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `tbbodega`
--

DROP TABLE IF EXISTS `tbbodega`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbbodega` (
  `Codigo` varchar(10) NOT NULL,
  `Disponibles` int(11) NOT NULL DEFAULT '0',
  `Reservados` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbbodega`
--

LOCK TABLES `tbbodega` WRITE;
/*!40000 ALTER TABLE `tbbodega` DISABLE KEYS */;
INSERT INTO `tbbodega` VALUES ('ART-123',3,-1),('H123',2,-1);
/*!40000 ALTER TABLE `tbbodega` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbcategoria`
--

DROP TABLE IF EXISTS `tbcategoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbcategoria` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(30) NOT NULL,
  `IdCategoria` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `fkIdCategoria` (`IdCategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbcategoria`
--

LOCK TABLES `tbcategoria` WRITE;
/*!40000 ALTER TABLE `tbcategoria` DISABLE KEYS */;
INSERT INTO `tbcategoria` VALUES (1,'CategorÃ­a',0),(2,'SubcategorÃ­a',1);
/*!40000 ALTER TABLE `tbcategoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbcliente`
--

DROP TABLE IF EXISTS `tbcliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbcliente` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(30) NOT NULL,
  `Correo` varchar(30) NOT NULL,
  `Telefono` varchar(9) NOT NULL,
  `Direccion` varchar(200) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbcliente`
--

LOCK TABLES `tbcliente` WRITE;
/*!40000 ALTER TABLE `tbcliente` DISABLE KEYS */;
INSERT INTO `tbcliente` VALUES (7,'Alvaro','yahoo@yahoo.com','8888-9898','Bella Vista'),(8,'Gabriel','mail@mail.com','8778-7447','Roxana'),(38,'Jose Ramirez','jram@hotmail.com','76564312','Toro Amarillo, GuÃ¡piles');
/*!40000 ALTER TABLE `tbcliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbeven-art`
--

DROP TABLE IF EXISTS `tbeven-art`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbeven-art` (
  `Codigo_Articulo` varchar(10) NOT NULL,
  `Id_Evento` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  PRIMARY KEY (`Codigo_Articulo`,`Id_Evento`),
  KEY `Id_Evento` (`Id_Evento`),
  CONSTRAINT `tbeven-art_ibfk_2` FOREIGN KEY (`Id_Evento`) REFERENCES `tbevento` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbeven-art`
--

LOCK TABLES `tbeven-art` WRITE;
/*!40000 ALTER TABLE `tbeven-art` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbeven-art` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger after_insert_articuloevento
after insert on `tbeven-art`
for each row
begin
	update tbbodega set Reservados = Reservados +1, Disponibles= Disponibles - 1;
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger after_delete_articuloevento
after delete on `tbeven-art`
for each row
begin
	update tbbodega set Reservados = Reservados -1, Disponibles= Disponibles + 1;
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `tbevento`
--

DROP TABLE IF EXISTS `tbevento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbevento` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  `FechaInicio` date NOT NULL,
  `FechaFinal` date NOT NULL,
  `Ubicacion` varchar(200) NOT NULL,
  `Id_Cliente` int(11) NOT NULL,
  PRIMARY KEY (`Id`,`Id_Cliente`),
  KEY `Id_idx` (`Id_Cliente`),
  CONSTRAINT `tbevento_ibfk_1` FOREIGN KEY (`Id_Cliente`) REFERENCES `tbcliente` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbevento`
--

LOCK TABLES `tbevento` WRITE;
/*!40000 ALTER TABLE `tbevento` DISABLE KEYS */;
INSERT INTO `tbevento` VALUES (82,'Test Event','2016-12-12','2016-12-12','Test Place',7);
/*!40000 ALTER TABLE `tbevento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbfactura`
--

DROP TABLE IF EXISTS `tbfactura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbfactura` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Id_Evento` int(11) NOT NULL,
  `Id_Cliente` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `Monto` double NOT NULL,
  `Monto_Total` double NOT NULL,
  `Descuento` double NOT NULL,
  PRIMARY KEY (`Id`,`Id_Evento`,`Id_Cliente`),
  KEY `Id_Cliente` (`Id_Cliente`),
  KEY `Id_Evento` (`Id_Evento`),
  CONSTRAINT `tbfactura_ibfk_1` FOREIGN KEY (`Id_Cliente`) REFERENCES `tbcliente` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbfactura_ibfk_2` FOREIGN KEY (`Id_Evento`) REFERENCES `tbevento` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbfactura`
--

LOCK TABLES `tbfactura` WRITE;
/*!40000 ALTER TABLE `tbfactura` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbfactura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblogin`
--

DROP TABLE IF EXISTS `tblogin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblogin` (
  `Usuario` varchar(30) NOT NULL,
  `Contrasena` varchar(30) NOT NULL,
  PRIMARY KEY (`Usuario`,`Contrasena`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblogin`
--

LOCK TABLES `tblogin` WRITE;
/*!40000 ALTER TABLE `tblogin` DISABLE KEYS */;
INSERT INTO `tblogin` VALUES ('a','a'),('a','s'),('login','1234'),('s','s');
/*!40000 ALTER TABLE `tblogin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbpago`
--

DROP TABLE IF EXISTS `tbpago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbpago` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Id_Factura` int(11) NOT NULL,
  `Monto` double NOT NULL,
  `Descripcion` varchar(200) NOT NULL,
  PRIMARY KEY (`Id`,`Id_Factura`),
  KEY `Id_Factura` (`Id_Factura`),
  CONSTRAINT `tbpago_ibfk_1` FOREIGN KEY (`Id_Factura`) REFERENCES `tbfactura` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbpago`
--

LOCK TABLES `tbpago` WRITE;
/*!40000 ALTER TABLE `tbpago` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbpago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbservicios`
--

DROP TABLE IF EXISTS `tbservicios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbservicios` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Id_Factura` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Descripcion` varchar(500) NOT NULL,
  `Precio` double NOT NULL,
  PRIMARY KEY (`Id`,`Id_Factura`),
  KEY `Id_Factura` (`Id_Factura`),
  CONSTRAINT `tbservicios_ibfk_1` FOREIGN KEY (`Id_Factura`) REFERENCES `tbfactura` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbservicios`
--

LOCK TABLES `tbservicios` WRITE;
/*!40000 ALTER TABLE `tbservicios` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbservicios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'db15cero2'
--
/*!50003 DROP PROCEDURE IF EXISTS `paAdministrarArticulo` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `paAdministrarArticulo`(IN `tipo` INT, IN `id_art` INT, IN `cod` VARCHAR(10), IN `id_categ` INT, IN `descrip` VARCHAR(500), IN `preci` DOUBLE, IN `estad` CHAR(1))
begin 
	if tipo = 1 then
		Select * from tbarticulo;
	elseif tipo = 2 then
		insert into tbarticulo values(null, cod,id_categ,descrip,preci,estad);
	elseif tipo = 3 then
		update tbarticulo set Codigo = cod, Id_Categoria = id_categ, Descripcion = descrip, Precio = preci, Estado = estad where Id = id_art;
	elseif tipo = 4 then
		delete from tbarticulo where Id = id_art;
    elseif tipo = 5 then -- Para seleccionar articulos por subcategoria
		select * from tbarticulo where Id_Categoria = id_categ;
	elseif tipo = 6 then -- Para seleccionar articulos por categoria
		select * from tbarticulo a inner join tbcategoria c on a.Id_Categoria=c.Id and c.IdCategoria=id_categ;
	elseif tipo = 7 then
		select cat.Id as idCat, cat.Nombre as nombreCat, 
			sub.Id as idSub, sub.Nombre as nombreSub,
            art.Estado as estado
		from tbcategoria cat inner join tbcategoria sub
		on cat.Id=sub.IdCategoria 
		inner join tbarticulo art 
		on art.Id_Categoria=sub.Id and art.Id=id_art;
    elseif tipo = 8 then
		select * from tbarticulo where Id_Categoria not in (select Id from tbcategoria);
	end if;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `paAdministrarBodega` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `paAdministrarBodega`(IN `tipo` INT, IN `cod` VARCHAR(10), IN `cant` INT)
begin 
	if tipo = 1 then
		select count(b.Codigo) from tbbodega b where b.Codigo in (select Codigo from tbbodega);
	elseif tipo = 2 then
		insert into tbbodega values(cod,cant);
	elseif tipo = 3 then
		update tbbodega set Cantidad = (cantidad+1) where Codigo = cod;
	elseif tipo = 4 then
		delete from tbbodega where Codigo = cod;
    elseif tipo = 5 then    
		select b.Codigo,b.Cantidad-ev.Cantidad `Disponibles`, ev.Cantidad as `Reservado` 
		from tbbodega b, `tbeven-art` ev 
		where ev.Codigo_Articulo=b.Codigo;
	end if;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `paAdministrarCategoria` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `paAdministrarCategoria`(IN `tipo` INT, IN `id_cat` INT, IN `nomb` VARCHAR(30), IN `categ` INT)
begin 
	if tipo = 1 then 
		select * from tbcategoria;
	elseif tipo = 2 then
		insert into tbcategoria values(null,nomb,categ);
	elseif tipo = 3 then   
		update tbcategoria set Nombre = nomb, IdCategoria = categ where Id = id_cat;
	elseif tipo = 4 then	
		delete from tbcategoria where Id = id_cat;
        delete from tbcategoria where IdCategoria=id_cat;
        -- eliminar articulos o pasarlos a una categoria 'Sin Categoria'
	elseif tipo = 5 then
		select * from tbcategoria where IdCategoria = 0;
	elseif tipo = 6 then
		select * from tbcategoria where IdCategoria = id_cat;
    end if;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `paAdministrarCliente` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `paAdministrarCliente`(IN `tipo` INT, IN `id_cli` INT, IN `nomb` VARCHAR(30), IN `corr` VARCHAR(30), IN `telef` VARCHAR(9), IN `direc` VARCHAR(200))
begin 
	if tipo = 1 then 
		select * from tbcliente;
	elseif tipo = 2 then
		insert into tbcliente values(null,nomb,corr,telef,direc);  
	elseif tipo = 3 then   
		update tbcliente set Nombre = nomb, Correo = corr, Telefono = telef, Direccion = direc where Id = id_cli;
	elseif tipo = 4 then	
		delete from tbcliente where Id = id_cli;
	end if;
    if tipo = 2 then 
		select max(Id) as Id from tbcliente;
	end if;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `paAdministrarEvento` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `paAdministrarEvento`(IN `tipo` INT, IN `id_even` INT, IN `nomb` VARCHAR(100), IN `fechaIni` DATE, IN `fechaFin` DATE, IN `ubica` VARCHAR(200), IN `id_cli` INT)
begin 
	if tipo = 1 then 
		select e.*, c.Nombre as NombreCli from tbevento e inner join tbcliente c on e.Id_Cliente = c.Id;
	elseif tipo = 2 then
		insert into tbevento values(null, nomb, fechaIni, fechaFin,ubica,id_cli);
	elseif tipo = 3 then   
		update tbevento set Nombre = nomb, FechaInicio = fechaIni, FechaFinal = fechaFi, Ubicacion = ubica where Id = id_even;
	elseif tipo = 4 then	
		delete from tbevento where Id = id_even;
	end if;
    if tipo = 2 then
		select max(Id) as Id from tbevento;
    end if;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `paAdministrarEven_Art` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `paAdministrarEven_Art`(IN `tipo` INT, IN `id_art` VARCHAR(10), IN `id_even` INT, IN `cant` INT)
begin 
	if tipo = 1 then
		select a.Descripcion,ea.Cantidad from `tbeven-art` ea inner join tbarticulo a on ea.Codigo_Articulo = a.Codigo where ea.Id_Evento = id_even;
	elseif tipo = 2 then
		insert into `tbeven-art` values(id_art,id_even, cant);
	elseif tipo = 3 then   
		update `tbeven-art` set Cantidad = cant where Id_Articulo = id_art and Id_Evento = d_even;
	elseif tipo = 4 then	
		delete from `tbeven-art` where Id_Articulo = id_art and Id_Evento = d_even;
	end if;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `paAdministrarFactura` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `paAdministrarFactura`(IN `tipo` INT, IN `id_fact` INT, IN `id_even` INT, IN `id_cli` INT, IN `fech` DATE, IN `mont` DOUBLE, IN `mont_total` DOUBLE, IN `descuent` DOUBLE)
begin 
	if tipo = 1 then 
		select * from tbfactura;
	elseif tipo = 2 then
		insert into tbfactura values(null, id_even, id_cli, fech,mont, mont_total, descuent);
	elseif tipo = 3 then   
		update tbfactura set Fecha = fech,  Monto = mont, Monto_Total = mont_total, Descuento = descuent where Id = id_fact and Id_Evento = id_fact and Id_Cliente = id_cli;
	elseif tipo = 4 then	
		delete from tbfactura where Id = id_fact and Id_Evento = id_fact and Id_Cliente = id_cli;
	end if;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `paAdministrarLogin` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `paAdministrarLogin`(IN `tipo` INT, IN `user` VARCHAR(30), IN `pass` VARCHAR(30))
begin 
	if tipo = 1 then 
		select * from tblogin;
	elseif tipo = 2 then
		insert into tblogin values(user, pass);
				elseif tipo = 4 then	
		delete from tblogin where Usuario = user and Contrasena = pass;
	end if;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `paAdministrarPago` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `paAdministrarPago`(IN `tipo` INT, IN `id_pago` INT, IN `id_fact` INT, IN `mont` DOUBLE, IN `descrip` VARCHAR(200))
begin 
	if tipo = 1 then 
		select * from tbpago;
	elseif tipo = 2 then
		insert into tbpago values(null, id_fact, mont, descrip);
	elseif tipo = 3 then   
		update tbpago set Monto = mont, Descripcion = descrip where Id = id_pago;
	elseif tipo = 4 then	
		delete from tbpago where Id = id_pago;
	end if;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `paAdministrarServicios` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `paAdministrarServicios`(IN `tipo` INT, IN `id_serv` INT, IN `id_fact` INT, IN `nomb` VARCHAR(100), IN `descrip` VARCHAR(500), IN `prec` DOUBLE)
begin 
	if tipo = 1 then 
		select * from tbservicios;
	elseif tipo = 2 then
		insert into tbservicios values(null, id_fact, nomb, descrip, prec);
	elseif tipo = 3 then   
		update tbservicios set Nombre = nomb, Descripcion = descrip, Precio = prec where Id = id_serv;
	elseif tipo = 4 then	
		delete from tbservicios where Id = id_serv;
	end if;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `paVerificarLogin` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `paVerificarLogin`(IN `user` VARCHAR(30), IN `pass` VARCHAR(30))
begin 
	select * from tblogin where Usuario = user and Contrasena = pass;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-25 16:48:28
