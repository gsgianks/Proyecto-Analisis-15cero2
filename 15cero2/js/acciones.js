$(document).ready(function () {
	//para que las notificaciones en la esquina superior derecha
	alertify.set('confirm','transition', 'fade');
    alertify.set('notifier','position', 'top-right');
    
    //funcion para que aparezca el formulario de agregar un nuevo cliente en el formulario de evento
    $("#clientes").change(function(){

        if($("#clientes").val() == 0){
            $('#id04').css("display", "block");   
        }
    });

    //funcion para que aparezca el formulario de agregar un nuevo cliente en el formulario de evento cuando se modifica un evento
    $("#clientesModal").change(function(){

        if($("#clientesModal").val() == 0){
            $("#clienteNuevoModal").css("display", "block"); 
            $("#id03 .formulario").css("margin-left","2%");
            //alert("agregar nuevo");    
        }else if($("#clientesModal").val() != 0){
            //alert("diferente");
            $("#clienteNuevoModal").css("display", "none"); 
            $("#id03 .formulario").css("margin-left","25%");
            $('.formulario input[name=nombreCliente]').val($("#clientesModal option[value="+$("#clientesModal").val()+"]").text());
            //alert($('.formulario input[name=nombreCliente]').val());
            //alert($("#clientesModal option[value="+$("#clientesModal").val()+"]").text());
        }
    });
});

//funcion para rediregir de un evento ha agregar activos a ese evento
function agregarActivosEvento(evento,name){
    alert('redireccion '+evento+' - '+name);
    window.location = 'insertar_activo_evento.php?e='+evento+'&n='+name;
}

//funcion para cargar los datos del evento en el informe
function cargarEvento(id_even){
    alert("evento: "+id_even);
    window.location = 'informe_evento.php?e='+id_even;
    /*var data = {consulta : 'seleccionarEvento',id_event : id_even};    
    ajax('controladoras/controladora_evento.php',data);*/
}