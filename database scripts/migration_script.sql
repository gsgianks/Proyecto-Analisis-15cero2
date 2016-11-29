-- ----------------------------------------------------------------------------
-- MySQL Workbench Migration
-- Migrated Schemata: db15cero2
-- Source Schemata: db15cero2
-- Created: Sat Nov 26 22:00:24 2016
-- Workbench Version: 6.3.7
-- ----------------------------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------------------------------------------------------
-- Schema db15cero2
-- ----------------------------------------------------------------------------
DROP SCHEMA IF EXISTS `db15cero2` ;
CREATE SCHEMA IF NOT EXISTS `db15cero2` ;

-- ----------------------------------------------------------------------------
-- Table db15cero2.tbarticulo
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `db15cero2`.`tbarticulo` (
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  `Codigo` VARCHAR(10) NOT NULL,
  `Id_Categoria` INT(11) NOT NULL,
  `Descripcion` VARCHAR(500) NOT NULL,
  `Precio` DOUBLE NOT NULL,
  `Estado` CHAR(1) NOT NULL,
  PRIMARY KEY (`Id`),
  INDEX `Id_Categoria` (`Id_Categoria` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 31
DEFAULT CHARACTER SET = latin1;

-- ----------------------------------------------------------------------------
-- Table db15cero2.tbbodega
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `db15cero2`.`tbbodega` (
  `Codigo` VARCHAR(10) NOT NULL,
  `Disponibles` INT(11) NOT NULL DEFAULT '0',
  `Reservados` INT(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Codigo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

-- ----------------------------------------------------------------------------
-- Table db15cero2.tbcategoria
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `db15cero2`.`tbcategoria` (
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(30) NOT NULL,
  `IdCategoria` INT(11) NOT NULL,
  PRIMARY KEY (`Id`),
  INDEX `fkIdCategoria` (`IdCategoria` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = latin1;

-- ----------------------------------------------------------------------------
-- Table db15cero2.tbcliente
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `db15cero2`.`tbcliente` (
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(30) NOT NULL,
  `Correo` VARCHAR(30) NOT NULL,
  `Telefono` VARCHAR(9) NOT NULL,
  `Direccion` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`Id`))
ENGINE = InnoDB
AUTO_INCREMENT = 40
DEFAULT CHARACTER SET = latin1;

-- ----------------------------------------------------------------------------
-- Table db15cero2.tbeven_art
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `db15cero2`.`tbeven_art` (
  `Id_Evento` INT(11) NOT NULL,
  `Id_Articulo` INT(11) NOT NULL,
  PRIMARY KEY (`Id_Evento`, `Id_Articulo`),
  INDEX `fk_IdArticulo` (`Id_Articulo` ASC),
  CONSTRAINT `fk_IdArticulo`
    FOREIGN KEY (`Id_Articulo`)
    REFERENCES `db15cero2`.`tbarticulo` (`Id`),
  CONSTRAINT `fk_IdEvento`
    FOREIGN KEY (`Id_Evento`)
    REFERENCES `db15cero2`.`tbevento` (`Id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

-- ----------------------------------------------------------------------------
-- Table db15cero2.tbevento
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `db15cero2`.`tbevento` (
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(100) NOT NULL,
  `FechaInicio` DATE NOT NULL,
  `FechaFinal` DATE NOT NULL,
  `Ubicacion` VARCHAR(200) NOT NULL,
  `Id_Cliente` INT(11) NOT NULL,
  PRIMARY KEY (`Id`, `Id_Cliente`),
  INDEX `Id_idx` (`Id_Cliente` ASC),
  CONSTRAINT `tbevento_ibfk_1`
    FOREIGN KEY (`Id_Cliente`)
    REFERENCES `db15cero2`.`tbcliente` (`Id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 85
DEFAULT CHARACTER SET = latin1;

-- ----------------------------------------------------------------------------
-- Table db15cero2.tbfactura
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `db15cero2`.`tbfactura` (
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  `Id_Evento` INT(11) NOT NULL,
  `Id_Cliente` INT(11) NOT NULL,
  `Fecha` DATE NOT NULL,
  `Monto` DOUBLE NOT NULL,
  `Monto_Total` DOUBLE NOT NULL,
  `Descuento` DOUBLE NOT NULL,
  PRIMARY KEY (`Id`, `Id_Evento`, `Id_Cliente`),
  INDEX `Id_Cliente` (`Id_Cliente` ASC),
  INDEX `Id_Evento` (`Id_Evento` ASC),
  CONSTRAINT `tbfactura_ibfk_1`
    FOREIGN KEY (`Id_Cliente`)
    REFERENCES `db15cero2`.`tbcliente` (`Id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `tbfactura_ibfk_2`
    FOREIGN KEY (`Id_Evento`)
    REFERENCES `db15cero2`.`tbevento` (`Id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

-- ----------------------------------------------------------------------------
-- Table db15cero2.tblogin
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `db15cero2`.`tblogin` (
  `Usuario` VARCHAR(30) NOT NULL,
  `Contrasena` VARCHAR(30) NOT NULL,
  PRIMARY KEY (`Usuario`, `Contrasena`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

-- ----------------------------------------------------------------------------
-- Table db15cero2.tbpago
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `db15cero2`.`tbpago` (
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  `Id_Factura` INT(11) NOT NULL,
  `Monto` DOUBLE NOT NULL,
  `Descripcion` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`Id`, `Id_Factura`),
  INDEX `Id_Factura` (`Id_Factura` ASC),
  CONSTRAINT `tbpago_ibfk_1`
    FOREIGN KEY (`Id_Factura`)
    REFERENCES `db15cero2`.`tbfactura` (`Id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

-- ----------------------------------------------------------------------------
-- Table db15cero2.tbservicios
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `db15cero2`.`tbservicios` (
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  `Id_Factura` INT(11) NOT NULL,
  `Nombre` VARCHAR(100) NOT NULL,
  `Descripcion` VARCHAR(500) NOT NULL,
  `Precio` DOUBLE NOT NULL,
  PRIMARY KEY (`Id`, `Id_Factura`),
  INDEX `Id_Factura` (`Id_Factura` ASC),
  CONSTRAINT `tbservicios_ibfk_1`
    FOREIGN KEY (`Id_Factura`)
    REFERENCES `db15cero2`.`tbfactura` (`Id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

-- ----------------------------------------------------------------------------
-- Routine db15cero2.paAdministrarArticulo
-- ----------------------------------------------------------------------------
DELIMITER $$

DELIMITER $$
USE `db15cero2`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `paAdministrarArticulo`(IN `tipo` INT, IN `id_art` INT, IN `cod` VARCHAR(10), IN `id_categ` INT, IN `descrip` VARCHAR(500), IN `preci` DOUBLE, IN `estad` CHAR(1))
begin 
	if tipo = 1 then
		Select * from tbarticulo;
	elseif tipo = 2 then
		insert into tbarticulo values(null, cod,id_categ,descrip,preci,estad);
	elseif tipo = 3 then
		update tbarticulo set Id_Categoria = id_categ, Descripcion = descrip, Precio = preci, Estado = estad where Id = id_art;
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
end$$

DELIMITER ;

-- ----------------------------------------------------------------------------
-- Routine db15cero2.paAdministrarBodega
-- ----------------------------------------------------------------------------
DELIMITER $$

DELIMITER $$
USE `db15cero2`$$
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
end$$

DELIMITER ;

-- ----------------------------------------------------------------------------
-- Routine db15cero2.paAdministrarCategoria
-- ----------------------------------------------------------------------------
DELIMITER $$

DELIMITER $$
USE `db15cero2`$$
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
end$$

DELIMITER ;

-- ----------------------------------------------------------------------------
-- Routine db15cero2.paAdministrarCliente
-- ----------------------------------------------------------------------------
DELIMITER $$

DELIMITER $$
USE `db15cero2`$$
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
end$$

DELIMITER ;

-- ----------------------------------------------------------------------------
-- Routine db15cero2.paAdministrarEvento
-- ----------------------------------------------------------------------------
DELIMITER $$

DELIMITER $$
USE `db15cero2`$$
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
end$$

DELIMITER ;

-- ----------------------------------------------------------------------------
-- Routine db15cero2.paAdministrarEven_Art
-- ----------------------------------------------------------------------------
DELIMITER $$

DELIMITER $$
USE `db15cero2`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `paAdministrarEven_Art`(IN `tipo` INT, IN `id_art` VARCHAR(10), IN `id_even` INT, IN `cant` INT)
begin 
	if tipo = 1 then
		select art.Descripcion,count(art.Codigo) as Cantidad
		from tbarticulo art, tbevento ev, tbeven_art ea
		where ev.Id=`id_even` and art.Id=ea.Id_Articulo
		group by art.Descripcion, art.Codigo;        
	elseif tipo = 2 then
		insert into `tbeven_art` values(id_even,id_art);
	-- elseif tipo = 3 then   
		-- update `tbeven-art` set Cantidad = cant where Id_Articulo = id_art and Id_Evento = d_even;
	elseif tipo = 4 then
		delete from `tbeven_art` where Id_Articulo = id_art and Id_Evento = d_even;
	end if;
end$$

DELIMITER ;

-- ----------------------------------------------------------------------------
-- Routine db15cero2.paAdministrarFactura
-- ----------------------------------------------------------------------------
DELIMITER $$

DELIMITER $$
USE `db15cero2`$$
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
end$$

DELIMITER ;

-- ----------------------------------------------------------------------------
-- Routine db15cero2.paAdministrarLogin
-- ----------------------------------------------------------------------------
DELIMITER $$

DELIMITER $$
USE `db15cero2`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `paAdministrarLogin`(IN `tipo` INT, IN `user` VARCHAR(30), IN `pass` VARCHAR(30))
begin 
	if tipo = 1 then 
		select * from tblogin;
	elseif tipo = 2 then
		insert into tblogin values(user, pass);
				elseif tipo = 4 then	
		delete from tblogin where Usuario = user and Contrasena = pass;
	end if;
end$$

DELIMITER ;

-- ----------------------------------------------------------------------------
-- Routine db15cero2.paAdministrarPago
-- ----------------------------------------------------------------------------
DELIMITER $$

DELIMITER $$
USE `db15cero2`$$
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
end$$

DELIMITER ;

-- ----------------------------------------------------------------------------
-- Routine db15cero2.paAdministrarServicios
-- ----------------------------------------------------------------------------
DELIMITER $$

DELIMITER $$
USE `db15cero2`$$
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
end$$

DELIMITER ;

-- ----------------------------------------------------------------------------
-- Routine db15cero2.paVerificarLogin
-- ----------------------------------------------------------------------------
DELIMITER $$

DELIMITER $$
USE `db15cero2`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `paVerificarLogin`(IN `user` VARCHAR(30), IN `pass` VARCHAR(30))
begin 
	select * from tblogin where Usuario = user and Contrasena = pass;
end$$

DELIMITER ;

-- ----------------------------------------------------------------------------
-- Trigger db15cero2.after_insert_articulo
-- ----------------------------------------------------------------------------
DELIMITER $$
USE `db15cero2`$$
CREATE DEFINER=`root`@`localhost` trigger after_insert_articulo
after insert on tbarticulo
for each row
begin

	if exists(select Codigo from tbbodega where Codigo=NEW.Codigo) then
		update tbbodega set Disponibles = Disponibles +1 where Codigo=NEW.Codigo;
	else
		insert into tbbodega values(NEW.Codigo, 1, 0);
	end if;
end;

-- ----------------------------------------------------------------------------
-- Trigger db15cero2.after_delete_articulo
-- ----------------------------------------------------------------------------
DELIMITER $$
USE `db15cero2`$$
CREATE DEFINER=`root`@`localhost` trigger after_delete_articulo
after delete on tbarticulo
for each row
begin
    if (select Reservados from tbbodega where Codigo=OLD.Codigo) > 0 then
		update tbbodega 
        set Reservados= Reservados -1, Disponibles=Disponibles-1
        where Codigo=OLD.Codigo;
        
	elseif(select Reservados from tbbodega where Codigo=OLD.Codigo) = 0 then
		update tbbodega 
        set Disponibles= Disponibles -1 
        where Codigo=OLD.Codigo;
	end if;
    
    if (select Disponibles + Reservados from tbbodega where Codigo=OLD.Codigo) = 0 then
		delete from tbbodega where Codigo=OLD.Codigo;
	end if;
end;

-- ----------------------------------------------------------------------------
-- Trigger db15cero2.after_insert_evento_articulo
-- ----------------------------------------------------------------------------
DELIMITER $$
USE `db15cero2`$$
CREATE DEFINER=`root`@`localhost` trigger after_insert_evento_articulo
after insert on tbeven_art
for each row
begin
	update tbbodega 
    set Disponibles = Disponibles -1, Reservados = Reservados +1
    where Codigo in 
		(select Codigo
			from tbarticulo
            where Id=NEW.Id_Articulo);
end;

-- ----------------------------------------------------------------------------
-- Trigger db15cero2.after_delete_evento_articulo
-- ----------------------------------------------------------------------------
DELIMITER $$
USE `db15cero2`$$
CREATE DEFINER=`root`@`localhost` trigger after_delete_evento_articulo
after delete on tbeven_art
for each row
begin
	update tbbodega 
    set Disponibles = Disponibles +1, Reservados = Reservados -1
    where Codigo in 
		(select Codigo
			from tbarticulo
            where Id=OLD.Id_Articulo);
end;
SET FOREIGN_KEY_CHECKS = 1;
