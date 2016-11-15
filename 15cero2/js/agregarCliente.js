$(document).ready(function () {
    alertify.set('confirm','transition', 'fade');
    alertify.set('notifier','position', 'top-right');
    
   $("#clientes").change(function(){

        if($("#clientes").val() == 0){
            $("#clienteNuevo").css("display", "block"); 
            $(".formulario").css("margin-left","4%");
            //alert("agregar nuevo");    
        }else if($("#clientes").val() != 0){
            //alert("diferente");
            $("#clienteNuevo").css("display", "none"); 
            $(".formulario").css("margin-left","20%");
            //alert($("#clientes option[value="+$("#clientes").val()+"]").text());
        }
    });

    $("#clientesModal").change(function(){

        if($("#clientesModal").val() == 0){
            $("#clienteNuevoModal").css("display", "block"); 
            $("#id03 .formulario").css("margin-left","4%");
            //alert("agregar nuevo");    
        }else if($("#clientesModal").val() != 0){
            //alert("diferente");
            $("#clienteNuevoModal").css("display", "none"); 
            $(".formulario").css("margin-left","20%");
            $('.formulario input[name=nombreCliente]').val($("#clientesModal option[value="+$("#clientesModal").val()+"]").text());
            //alert($('.formulario input[name=nombreCliente]').val());
            //alert($("#clientesModal option[value="+$("#clientesModal").val()+"]").text());
        }
    });

    $("#categorias").change(function(){

        if($("#categorias").val() != 0){
            //alert("diferente");
            var datas = {consulta : 'selectPorCategoria', identificador : 5,categoria : $('#categorias').val()};
           // alert(datas.consulta +"  -  "+datas.identificador+"   -    "+datas.categoria);
            ajax('controladoras/ActivosController.php', datas);
        }
    });
    $("#activos").change(function(){
        //alert("cambio");
        var data = {consulta : 'cantidadActivos',codigo : $('#activos').val()};
        ajax('controladoras/controladora_evento_activo.php',data);
    });
});
function ajax(urll, datas){
    //alert(urll+"uusgdbjsdkbvisdkavbn");
    $.ajax({
            url: urll,
            type: 'post',
            dataType: 'json',
            data: datas,
            success: function (resp) {
                //alert("respuesta: "+resp.Type);
                if(resp.Type === 'selectPorCategoria'){
                    selectPorCategoria(resp.Success,resp.Activos);
                }else if(resp.Type === 'eliminarActivoEvento'){
                    respEliminarActivoEvento(resp.Success, resp.Activo);
                }else if(resp.Type === 'seleccionarActivosEventos'){
                    seleccionarActivosEventos(resp.Success, resp.Activos, resp.Evento);
                }else if(resp.Type === "eliminarEvento"){
                    //alert("eliminarEvento");
                    respEliminarEvento(resp.Success,resp.Evento);
                }else if(resp.Type === 'eliminarCliente'){
                    respEliminarCliente(resp.Success,resp.Cliente);
                }else if(resp.Type === 'cantidadActivos'){
                    //alert("cantidadActivos "+resp.cantidad);
                    $('#cantidad_maxima').text(resp.cantidad);
                }/*else if(resp.Type === 'cargarEvento'){
                    alert("evento recuperado");
                    respCargarEvento(resp.Success, resp.Evento, resp.Nombre, resp.FechaIni, resp.FechaFin,resp.Cliente,resp.Ubicacion,resp.nombreCliente);
                }*/
               
            },
            error: function (jqXHR, estado, error) {
                alert('error varo gay');
                console.log("fallo");
            }
    });
}
function eliminarActivoEvento(boton){

    alertify.confirm('Confirmaci&oacute;n','&#191;Desea eliminar permanentem?', function(){ 
        var data = {consulta : 'eliminarActivoEvento',evento : $('input[name=evento]').val(),activo : $(boton).attr('name')};
        ajax('controladoras/controladora_evento_activo.php',data);
     }, function(){ alertify.error('Cancel')});
    
}
function selectPorCategoria(success, activos){

    $("#activos option").remove();          
    if(success === true){
        for(i = 0;i<activos.length;i++){                
            $('#activos').append("<option value='"+activos[i][1]+"'>"+activos[i][3]+"</option>");
        }
        var data = {consulta : 'cantidadActivos',codigo : activos[0][1]};
        ajax('controladoras/controladora_evento_activo.php',data);

    }else{
        $('#activos').append("<option value='0'>No hay resultados sirve prueba</option>");
    }
}
function respEliminarActivoEvento(success, activo){
    if(success === true){
        //alert('eliminado');
        //$(this).closest('tr').find("td").each(function(j){
        alertify.notify('Activo Eliminado', 'success', 5);
        $("#table tbody tr").each(function (index) 
        {
            $(this).children("td").each(function (index2) 
            {
                if(index2 === 0 && $(this).text() === activo){
                    //alert("la reputa mierda");
                    //alert($('#table tr').length);
                    //$(this).closest('tr').fadeOut(300);
                    //interval = setInterval(function(){},300);
                    //clearInterval(interval);
                    $(this).closest('tr').remove();
                    //$(this).closest('tr').remove();
                    //alert($('#table tr').length);
                    if($('#table tr').length <= 1){
                       $('#table').remove();
                       $('.activos-necesarios').html('<h3>Activos necesarios</h3><p>No hay activos asignados</p>');
                    }
                }
            })            
        })
    }else{
        alert('ERROR - algo ocurrió!');
    }
}
function mostrarDetalleEvento(ide){
    //alert('mostrarDetalleEvento   '+ide);
    var data = {consulta: 'seleccionarActivosEventos', id:ide};
    ajax('controladoras/controladora_evento_activo.php',data);
}
function seleccionarActivosEventos(success, activos, evento){
    //alert(evento);
    if(success === true){
        //alert("true");    
        var html = '<table><tr><td>Nombre</td><td>Fecha Inicio</td><td>Fecha Final</td><td>Lugar</td><td>Nombre Cliente</td></tr><tr>';
        var activar = false;
        var numero = 0;
        $("#table-eventos tbody tr").each(function (index) 
        {
            $(this).children("td").each(function (index2) 
            {
                if(index2 === 0 && $(this).text() === evento){
                    activar = true;

                    //alert('encontrado ' )
                }
                if(activar == true && numero<6){
                    if(numero>0){
                       html+='<td>'+$(this).text()+'</td>'
                    }
                    if(numero === 1){
                            nombre = "'"+$(this).text()+"'";
                            //alert('name'+nombre);
                        } 
                     numero++;
                }
            })            
        })
        html += '</tr></table><table id="table-activos"><tr><td>Descipci&oacute;n</td><td>Cantidad</td></tr>';
        for(i = 0;i<activos.length;i++){                
            html+='<tr><td>'+activos[i][0]+'</td><td>'+activos[i][1]+'</td></tr>';
        }
        html+='</table><button onClick="agregarActivosEvento('+evento+','+nombre+')">Modificar Activos</button>'
        //alert(html);
        $(".div-modal2").html(html);
    }else{
        
        var html = '<table><tr><td>Nombre</td><td>Fecha Inicio</td><td>Fecha Final</td><td>Lugar</td><td>Nombre Cliente</td></tr><tr>';
        var activar = false;
        var numero = 0;
        var nombre = 'hola';
        $("#table-eventos tbody tr").each(function (index) {
            $(this).children("td").each(function (index2) {
                
                if(index2 === 0 && $(this).text() === evento){
                    activar = true;
                }
                if(activar == true && numero<6){
                   // alert($(this).text());
                    if(numero>0){
                       html+='<td>'+$(this).text()+'</td>'
                    }
                    if(numero === 1){
                            nombre = "'"+$(this).text()+"'";
                            //alert('name'+nombre);
                        } 
                    numero++;
                    
                }
            });            
        });
        //alert(evento+' '+nombre);
        html += '</tr></table><h4>No hay activos asignados</h4><button onClick="agregarActivosEvento('+evento+','+nombre+')">Agregar Activos</button>';
        $(".div-modal2").html(html);
    }
    $('#id02').css("display", "block"); 
}
function agregarActivosEvento(evento,name){
    alert('redireccion '+evento+' - '+name);
    window.location = 'insertar_activo_evento.php?e='+evento+'&n='+name;
}
function modificarEvento(idEvento){
   // alert("modificar Evento: "+idEvento +" jaja "+$(".div-modal3 input[name=nombreEven]").val());
    var condicion = false;
    //$(".div-modal3 input[name=nombreEven]").val("hoal");
    $("#table-eventos tbody tr").each(function (index) 
        {
            $(this).children("td").each(function (index2) 
            {
                
                if(index2 === 0 && $(this).text() == idEvento){
                    condicion = true;
                }
                if(condicion === true){
                    if(index2 == 0){                        
                        $(".div-modal3 input[name=idEvento]").val($(this).text());
                    }else if(index2 == 1){
                        $(".div-modal3 input[name=nombreEven]").val($(this).text());

                    }else if(index2 == 2){
                        $(".div-modal3 input[name=fechaIni]").val($(this).text());

                    }else if(index2 == 3){
                        $(".div-modal3 input[name=fechaFin]").val($(this).text());
                    }else if(index2 == 4){
                        $(".div-modal3 input[name=ubicacion]").val($(this).text());
                    }else if(index2 == 5){
                        var temp = $(this).text();
                        $("#clientesModal option").each(function(){                        
                            if($(this).text() == temp){
                                $(this).attr('selected','selected');
                                 $('.formulario input[name=nombreCliente]').val($(this).text());
                            }else{
                                $(this).removeAttr("selected");    
                            }

                        });
                        //alert($('.opciones>td[idCliente]').attr('idCliente'));
                        //$('#clientesModal>option[value='+$('.opciones>td[idCliente]').attr('idCliente')+']').attr('selected','selected');
                        condicion = false;
                    }
                }
            });           
        });
    $('#id03').css("display", "block");
    //$('#id03').removeAttr('display');
}
function eliminarEvento(idEvento){
    alertify.confirm('Confirmaci&oacute;n','&#191;Desea eliminar permanentem?', function(){ 
        var data = {consulta : 'eliminarEvento',evento : idEvento};
        ajax('controladoras/controladora_evento.php',data);
     }, function(){ alertify.error('Cancel')});   
}
function respEliminarEvento(success,evento){
    if(success === true){
        //alert("se eliminó");
         $("#table-eventos tbody tr").each(function (index) 
        {
            $(this).children("td").each(function (index2) 
            {
                if(index2 === 0 && $(this).text() === evento){
                    $(this).closest('tr').remove();
                    if($('#table-eventos tr').length == 1){
                       $('#table-eventos').remove();
                       $('.lista-eventos').html('<h3>Eventos registrados</h3><p>No hay eventos registrados</p>');
                    }
                }
            });           
        });
          alertify.notify('Evento Eliminado', 'success', 5);
    }else{
        alert("no se eliminó");
    }
}
function modificarCliente(idCliente){
    //alert("modificarCliente "+idCliente);
    $('.formulario input[name=consulta]').val('modificarCliente');
    $('.formulario h1').text('Modificar Cliente');
    $('.formulario input[type=submit]').val('Modificar');
    condicion = false;
    $("#table-clientes tbody tr").each(function (index) 
            {
                $(this).children("td").each(function (index2) 
                {
                    
                if(index2 === 0 && $(this).text() == idCliente){
                    condicion = true;
                }
                if(condicion === true){
                    if(index2 == 0){
                        $('.formulario input[name=idCliente]').val($(this).text());
                    }else if(index2 == 1){
                        $('.formulario input[name=nombre]').val($(this).text());
                    }else if(index2 == 2){
                        $('.formulario input[name=correo]').val($(this).text());
                    }else if(index2 == 3){
                        $('.formulario input[name=telefono]').val($(this).text());
                    }else if(index2 == 4){
                        $('.formulario input[name=direccion]').val($(this).text());
                        condicion = false;
                    }
                }
            });           
        });
     alertify.notify('Cliente Modificado', 'success', 5);
}
function eliminarCliente(idCliente){
    //alert("eliminarCliente");
    alertify.confirm('Confirmaci&oacute;n','¿Desea eliminar permanente?', function(){ 
        var data = {consulta : 'eliminarCliente',idCliente : idCliente};    
        ajax('controladoras/controladora_cliente.php',data);
     }, function(){ alertify.error('Cancel')});
} 
function respEliminarCliente(success,idCliente){
    if(success === true){
        alertify.notify('Cliente Eliminado', 'success', 5)
       // alert($('#table-clientes tr').length);
        $("#table-clientes tbody tr").each(function (index) 
            {
                $(this).children("td").each(function (index2) 
                {
                    
                if(index2 === 0 && $(this).text() == idCliente){
                   // alert("encontrado");
                   $(this).closest('tr').remove();

                   if($('#table-clientes tr').length <= 1){
                       $('#table-clientes').remove();
                       $('.lista-clientes').html('<h3>Clientes</h3><p>No hay clientes registrados</p>');
                    }
                    //$(this).closest('tr').fadeOut(300);
                }
            });           
        });
    }else{
        alert("ERROR: algo ocurrio");
    }
}

//metodo para cargar los datos del evento en el informe a traves de ajax
function cargarEvento(id_even){
    alert("evento: "+id_even);
     window.location = 'informe_evento.php?e='+id_even;
    /*var data = {consulta : 'seleccionarEvento',id_event : id_even};    
    ajax('controladoras/controladora_evento.php',data);*/
}

//metodo para mostrar los datos del evento consultado para el informe
/*function repCargarEvento(success, evento, Nombre, fechaIni, fechaFin,cliente,ubicacion,nombreCliente){
    var data = {consulta: 'seleccionarActivosEventos', id:ide};
    ajax('controladoras/controladora_evento_activo.php',data);
}*/
