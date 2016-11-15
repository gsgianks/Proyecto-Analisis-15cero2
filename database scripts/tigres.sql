use northwind;

-- MySQL trigger syntax
CREATE TRIGGER trigger_name trigger_time trigger_event
 ON table_name
 FOR EACH ROW
 BEGIN
 ...
 END;

-- The trigger name should follow the naming convention 
-- [trigger time]_[table name]_[trigger event]
-- for example before_employees_update.

-- BEFORE UPDATE TRIGGER
CREATE TABLE employees_audit (
   id int(11) NOT NULL AUTO_INCREMENT,
   employeeNumber int(11) NOT NULL,
   lastname varchar(50) NOT NULL,
   changedon datetime DEFAULT NULL,
   action varchar(50) DEFAULT NULL,
   PRIMARY KEY (id)
);

DELIMITER $$
CREATE TRIGGER before_employee_update
    BEFORE UPDATE ON Employees
    FOR EACH ROW 
BEGIN
 
    INSERT INTO employees_audit
    SET action = 'update',
        employeeNumber = OLD.EmployeeID,
        lastname = OLD.LastName,
        changedon = NOW();
END$$
DELIMITER ;

SELECT * FROM Employees;

UPDATE Employees
SET lastName = 'Phan'
WHERE EmployeeID = 1;

SELECT * FROM employees_audit;

-- BEFORE DELETE TRIGGER
DELIMITER $$
CREATE TRIGGER before_order_delete
	BEFORE DELETE ON Orders FOR EACH ROW  
	BEGIN  
		DELETE FROM `order details` WHERE OLD.OrderID = OrderID;  
	END$$
DELIMITER ;

select * from orders where orderid =  10248;

select * from `order details` where orderid =  10248;

delete from orders where orderid = 10248;

-- AFTER INSERT TRIGGER
CREATE TABLE categories_log (
   category_id int(11) NOT NULL,
   item_number int(11) NOT NULL,
   PRIMARY KEY (category_id)
);

select * from categories_log;

insert into categories_log
select c.CategoryID, count(*) 
from Categories c inner join Products p on c.CategoryID=p.CategoryID
group by c.CategoryID;

DELIMITER $$
CREATE TRIGGER after_products_insert 
AFTER INSERT ON Products FOR EACH ROW  
BEGIN  
	UPDATE categories_log
	SET item_number = item_number+1
	WHERE category_id = NEW.CategoryID;
END$$
DELIMITER ;

select * from Products;

insert into Products(ProductID,ProductName,CategoryID) values(1003,'Frijoles',2);

-- PRACTICA: 
-- Crear tabla PreciosVenta
-- Todos los productos con un precio de venta de 30% al precio de costo
-- Crear Triggers, el precio de venta es 30% mas que el precio de compra.
-- after insert
-- after update

create table preciosventa(
id int(11),
precioventa decimal(10,4)
);

DELIMITER $$
CREATE TRIGGER after_products_insert  
    AFTER INSERT ON products FOR EACH ROW  
    BEGIN
       INSERT INTO preciosventa values
		(
			NEW.ProductID,
			NEW.UnitPrice * 1.3
		);
	END$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER after_products_update  
    AFTER UPDATE ON products FOR EACH ROW  
    BEGIN  
       UPDATE PreciosVenta  
       SET precioventa = (NEW.UnitPrice * 1.3)  
       WHERE id = NEW.ProductID;  
	END$$
DELIMITER ;

drop trigger after_products_insert;

insert into products(productID,productname,supplierid,categoryid,unitPrice) 
values (1008,'AAA',1,4,500);

update products
set unitprice = 100
where productid = 1008;

SELECT * FROM products;

SELECT * FROM preciosventa;

-- BEFORE INSERT PRODUCTS
desc Products;

CREATE TABLE products_users
( 
  ProductID int(5),
  User varchar(50),
  Date datetime,
  action varchar(50)
);

drop table products_users;

DELIMITER $$
CREATE TRIGGER before_products_insert  
    BEFORE INSERT ON Products FOR EACH ROW  
    BEGIN  
		INSERT INTO products_users values (NEW.ProductID,current_user(),NOW(),'Insert');
	END$$
DELIMITER ;

select * from products_users;

insert into Products(ProductID,ProductName) values (997,'PS4');

use db15cero2

-- AFTER DELETE PRODUCTS
DELIMITER $$
CREATE TRIGGER after_insert_articulo
    AFTER INSERT ON tbarticulo FOR EACH ROW  
    BEGIN  
		
		if exists(select codigo from tbbodega where NEW.codigo = codigo) then
			update tbbodega set cantidad=cantidad+1 where codigo = NEW.codigo;
        else 
			insert into tbbodega values (NEW.codigo,1);
        end if;
	END$$
DELIMITER ;


DELIMITER $$
CREATE TRIGGER after_delete_articulo
    AFTER DELETE ON tbarticulo FOR EACH ROW  
    BEGIN  
		if exists(select cantidad from tbbodega where old.codigo = codigo and cantidad >1) then
			update tbbodega set cantidad=cantidad-1 where codigo = old.codigo;
        else 
			delete from tbbodega where old.codigo = codigo;
        end if;
	END$$
DELIMITER ;

select cantidad from tbbodega where codigo = 'ELECT-32'
