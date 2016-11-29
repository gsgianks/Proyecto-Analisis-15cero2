delimiter ;;
create trigger after_delete_evento_articulo
after delete on tbeven_art
for each row
begin
	update tbbodega 
    set Disponibles = Disponibles +1, Reservados = Reservados -1
    where Codigo in 
		(select Codigo
			from tbarticulo
            where Id=OLD.Id_Articulo);
end;;
delimiter ;