delimiter ;;
create trigger after_delete_articulo
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
end;;
delimiter ;