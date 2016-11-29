delimiter ;;
create trigger after_update_articulo
after update on tbarticulo
for each row
begin
	update tbbodega set Disponibles = Disponibles -1 where Codigo=OLD.Codigo;
    insert into tbbodega values();
end;;
delimiter ;