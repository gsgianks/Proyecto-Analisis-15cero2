function ajaxFormularios(datas,urll){

    //alert("ajax fomrulario");
$.ajax({
            url: urll,
            type: 'post',
            dataType: 'json',
            data: datas,
            success: function (resp) {      
            //alert(resp.Type+" "+resp.Success+" "+resp.Consulta);        
                if(resp.Type === "cliente"){
                    clienteDesdeEnvento(resp.Success,resp.Id,resp.Name);
                }else if(resp.Type === 'evento'){
                    respEvento(resp.Success, resp.Location);
                }else if(resp.Type === 'activoEvento'){
                    respActivoEvento(resp.Success, resp);
                }else if(resp.Type === 'modificarEvento'){
                    respModificarEvento(resp.Success,resp.Nombre,resp.Evento,resp.FechaIni, resp.FechaFin,resp.Cliente, resp.Ubicacion, resp.nombreCliente);
                }else if(resp.Type === 'clienteForm'){
                    respCliente(resp.Success, resp.Id,resp.Name,resp.Correo,resp.Telefono,resp.Direccion);
                }else if(resp.Type === 'modificarCliente'){
                    respModificarCliente(resp.Success, resp.IdCliente, resp.Nombre,resp.Correo, resp.Telefono, resp.Direccion);
                }else if(resp.Type === 'cantidadActivos'){
                    //alert("cantidadActivos "+resp.cantidad);
                    $('#cantidad_maxima').text(resp.cantidad);
                   // $('#cantidad_activos').attr('max',resp.cantidad);
                }else if(resp.Type === 'agregarServicio'){
                    respAgregarServicio(resp.Success);
                }
            },
            error: function (jqXHR, estado, error) {
                alert('error log');
                console.log("fallo");
            }
        });
}

$(document).ready(function () {
    alertify.set('confirm','transition', 'fade');
    alertify.set('notifier','position', 'top-right');
    
    $('form').submit(function (e) {

        e.preventDefault();

        if(($(this).children('input[name=consulta]').val() == 'agregarActivosEvento') && (parseInt($(this).find('input[name=cantidad]').val()) > parseInt($('#cantidad_maxima').text()))) {
          alert("cantidad de activos no disponible");
        }else{

            var data = $(this).serializeArray();
            var url = $(this).attr("action");

            ajaxFormularios(data,url);
        }
    });
});

// comentario
function clienteDesdeEnvento(success,id,name){
    if($('#id03').css("display") == "none"){
        if(success === true){
            alertify.notify('Cliente Insertado', 'success', 5);
            $('#clientes').append("<option value="+id+" selected='selected'>"+name+"</option>");
            $('.div-modal4 input[type=text]').val('');
            $('.div-modal4 input[type=email]').val('');
            //$("#clienteNuevo").css("display", "none"); 
            //$(".formulario").css("margin-left","20%");  
            $('#id04').css("display", "none");
        }else{
            // aqui va el msj en alguna etiqueta
            alert("ERROR - algo ocurrio");
        }  
    }else{
        //alert("block");
        if(success === true){
            alertify.notify('Cliente Insertado', 'success', 5);
            $('.formulario input[name=nombreCliente]').val(name);  
            $('#clientesModal').append("<option value="+id+" selected='selected'>"+name+"</option>");
            $('#clienteNuevoModal input[type=text]').val('');
            $('#clienteNuevoModal input[type=email]').val('');
            $("#clienteNuevoModal").css("display", "none"); 
            $("#id03 .formulario").css("margin-left","25%"); 
              
        }else{
            // aqui va el msj en alguna etiqueta
            alert("ERROR - algo ocurrio");
    }  
    }   
}

//respuesta de agregar evento:redirige a insertar_activos_evento.pp
function respEvento(success,location){
    if(success === true){
        alertify.notify('Evento Insertado', 'success', 5);
        window.location = location;//+"?id="+id;        
    }else{
        // aqui va el msj en alguna etiqueta
        alert("ERROR - algo ocurrio");   
    }
}

//comentario
function respActivoEvento(success, resp){
    if(success === true){
        alertify.notify('Activo Insertado', 'success', 5);
        if($('#table').length=== 0){
            $('.activos-necesarios').html('<h3>Activos necesarios</h3><table id="table"><thead><tr><td>C&oacute;digo</td><td>Nombre</td><td>Cantidad</td><td>Acci&oacute;n</td></thead></tr><tr><td>'+$('#activos').val()+'</td><td>'+$('#activos').find(':selected').text()+'</td><td>'+$('input[name=cantidad]').val()+'</td><td><button style="color: black;" name="'+$('#activos').val()+'" onClick="eliminarActivoEvento(this)">Eliminar</button></td></tr></table>');
        }else{
            var temp = true;
             $("#table tbody tr").each(function (index) {
                if($('#activos').find(':selected').val() == $($(this).children("td")[0]).text()){
                    //alert("entro mierda");
                    temp = false;
                    $($(this).children("td")[2]).text(parseInt($($(this).children("td")[2]).text())+parseInt(resp.Cantidad));
                }
                //alert("*"+$($(this).children("td")[0]).text()+"*=*"+$('#activos').find(':selected').val()+"*");
            });
            if(temp){ 
                $('#table').append('<tr><td>'+$('#activos').val()+'</td><td>'+$('#activos').find(':selected').text()+'</td><td>'+$('input[name=cantidad]').val()+'</td><td><button style="color:black;" name="'+$('#activos').val()+'" onClick="eliminarActivoEvento(this)">Eliminar</button></td></tr>');
            }
        }

       

        //$('input[name=cantidad]').val('');
        var data = {consulta : 'cantidadActivos',codigo : $('#activos').val()};
        ajax('controladoras/controladora_evento_activo.php',data);
    }else{
        // aqui va el msj en alguna etiqueta
        alert("ERROR - algo ocurrio");   
    }
}

function respModificarEvento(success,nombre,evento,fechaIni, fechaFin,cliente, ubicacion,nombreCliente){
    if(success === true){
        alertify.notify('Evento Modificado', 'success', 5);
        $('#id03').css('display','none');
        /* -------------- */
        var condicion = false;
        //$(".div-modal3 input[name=nombreEven]").val("hoal");
        $("#table-eventos tbody tr").each(function (index) 
            {
                $(this).children("td").each(function (index2) 
                {
                    
                if(index2 === 0 && $(this).text() == evento){
                    condicion = true;
                }
                if(condicion === true){
                    if(index2 == 1){
                        $(this).text(nombre);
                    }else if(index2 == 2){
                        $(this).text(fechaIni);
                    }else if(index2 == 3){
                        $(this).text(fechaFin);
                    }else if(index2 == 4){
                        $(this).text(ubicacion);
                    }else if(index2 == 5){                        
                        //$(this).text($('#clientes>option[value='+cliente+']').text());
                        $(this).text(nombreCliente);
                        condicion = false;
                    }
                }
            });           
        });
        /* -------------- */
    }else{
        // aqui va el msj en alguna etiqueta
        alert("ERROR - algo ocurrio w");   
    }
}
//comentario
function respCliente(success, id,nombre,correo,telefono,direccion){
    if(success === true){
        $('.formulario input[type=text]').val('');
        $('.formulario input[type=email]').val('');
        if($('#table-clientes').length=== 0){
            //alert('no hay clientes');//$('.activos-necesarios').html('<h3>Activos necesarios</h3><table id="table"><tr><td>Id</td><td>Nombre</td><td>cantidad</td><td>Acci&oacute;n</td></tr><tr><td>'+$('#activos').val()+'</td><td>'+$('#activos').find(':selected').text()+'</td><td>'+$('input[name=cantidad]').val()+'</td><td><button name="'+$('#activos').val()+'" onClick="eliminarActivoEvento(this)">Eliminar</button></td></tr></table>');
            $('.lista-clientes').html('<h3>Clientes registrados</h3><table id="table-clientes" border="2"><tr><td>Nombre</td><td>Correo</td><td>Telefono</td><td>Direccion</td><td>Opciones</td></tr><tr><td style="display: none;">'+id+'</td><td>'+nombre+'</td><td>'+correo+'</td><td>'+telefono+'</td><td>'+direccion+'</td><td><ul class="options"><li><p>Opciones</p><ul><li><button onclick="modificarCliente('+id+');">Modificar</button></li><li><button onclick="eliminarCliente('+id+');">Eliminar</button></li></ul></li></ul></td></tr></table>');

        }else{
            $('#table-clientes').append('<tr><td style="display: none;">'+id+'</td><td>'+nombre+'</td><td>'+correo+'</td><td>'+telefono+'</td><td>'+direccion+'</td><td><ul class="options"><li><p>Opciones</p><ul><li><button onclick="modificarCliente('+id+');">Modificar</button></li><li><button onclick="eliminarCliente('+id+');">Eliminar</button></li></ul></li></ul></td></tr>');
        }
        alertify.notify('Cliente Insertado', 'success', 5);
    }else{
        // aqui va el msj en alguna etique
        alert("ERROR - algo ocurrio");   
    }
}

function respModificarCliente(success, idCliente, nombre,correo, telefono, direccion){
    if (success === true) {
        //alertify.notify('Cliente Modificado', 'success', 5); **********************////////////////////////*******************
        $("#table-clientes tbody tr").each(function (index) 
            {
                $(this).children("td").each(function (index2) 
                {
                    
                if(index2 === 0 && $(this).text() == idCliente){
                    condicion = true;
                }
                if(condicion === true){
                    if(index2 == 0){
                        $(this).text(idCliente);
                    }else if(index2 == 1){
                        $(this).text(nombre);
                    }else if(index2 == 2){
                        $(this).text(correo);
                    }else if(index2 == 3){
                        $(this).text(telefono);
                    }else if(index2 == 4){
                        $(this).text(direccion);
                        condicion = false;
                    }
                }
            });           
        });
        $('.div-editar-cliente input[type=text]').val("");
        $('.div-editar-cliente input[type=email]').val("");
        $('#modal-editar-cliente').css("display", "none"); 
       // $('.div-editar-cliente input[name=consulta]').val('agregarCliente');
        //$('.div-editar-cliente h1').text('Insertar Cliente');
        //$('.div-editar-cliente input[type=submit]').val('Agregar');
    }else{
        alert('Error: algo ocurrio');
    }
}

function respAgregarServicio(success){
    $('#id-service').css("display", "none");
    //alert("resp Servicio");
    //alert($("#id-service").find("select").val());
    if(success === true){
        alertify.notify('Servicio Insertado', 'success', 5);
        if($('#table').length=== 0){
            $('.activos-necesarios').html('<h3>Activos necesarios</h3><table id="table"><thead><tr><td>C&oacute;digo</td><td>Nombre</td><td>Cantidad</td><td>Acci&oacute;n</td></thead></tr><tr><td>Serv</td><td>'+$("#id-service").find("select").val()+'</td><td>1</td><td><button style="color: black;" name="'+$('#activos').val()+'" onClick="eliminarActivoEvento(this)">Eliminar</button></td></tr></table>');
        }else{            
            $('#table').append('<tr><td>Serv</td><td>'+$("#id-service").find("select").val()+'</td><td>1</td><td><button style="color:black;" name="'+$('#activos').val()+'" onClick="eliminarActivoEvento(this)">Eliminar</button></td></tr>');
        }
    }else{
        // aqui va el msj en alguna etiqueta
        alert("ERROR - algo ocurrio");   
    }
}