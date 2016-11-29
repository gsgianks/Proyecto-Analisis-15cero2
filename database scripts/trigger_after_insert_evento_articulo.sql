delimiter ;;
create trigger after_insert_evento_articulo
after insert on tbeven_art
for each row
begin
	update tbbodega 
    set Disponibles = Disponibles -1, Reservados = Reservados +1
    where Codigo in 
		(select Codigo
			from tbarticulo
            where Id=NEW.Id_Articulo);
end;;
delimiter ;