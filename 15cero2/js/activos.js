$(document).ready(
    function(){
        alertify.set('confirm','transition', 'fade');
        alertify.set('notifier','position', 'top-right');
        if($('.nav-alerts').text()!=''){alertify.notify($('.nav-alerts').text(),$('.nav-alerts').attr('type'),3);}
    }
);

function sincategoria(elm){
    $('.aside-left .lead a').removeClass("selected");
    table_content=$('table.table-stock>tbody');
    table_content.empty();
    $.ajax({
        type:'post',
        url:'./controladoras/ActivosController.php',
        data:{consulta:'seleccionarSinCategoria',ajax:'true'},
        dataType:'json',
        success:function(resp){
            content="";
            for(i=0; i<resp.length;i++){
                content+="<tr>"+
                    "<td>"+resp[i][0]+"</td>"+
                    "<td>"+resp[i][1]+"</td>"+
                    "<td>"+resp[i][2]+"</td>"+
                    "<td>"+resp[i][3]+"</td>"+
                    "<td>"+resp[i][4]+"</td>"+
                    "<td>"+resp[i][5]+"</td>"+
                    "<td>"+resp[i][6]+"</td>"+
                    "<td>"+
                        "<ul class='options'>"+
                            "<li>"+
                                "Opciones"+
                                "<ul>"+
                                    "<li><button onclick='showEditActive(\""+resp[i][0]+"\",\""+resp[i][1]+"\",\""+resp[i][3]+"\",\""+resp[i][6]+"\")'>Modificar</button><li>"+
                                    "<li><button onclick='showEditActiveStatus(\""+resp[i][0]+"\",\""+resp[i][3]+"\",\""+resp[i][4]+"\",\""+resp[i][5]+"\")'>Cambiar Estado</button><li>"+
                                    "<li><button onclick='showDeleteActive(\""+resp[i][0]+"\",\""+resp[i][3]+"\",\""+resp[i][4]+"\",\""+resp[i][5]+"\")'>Eliminar</button><li>"+
                                "</ul>"+
                            "</li>"+
                        "</ul>"+
                    "</td>"+
                "</tr>";
            }
            content="<tbody>"+content+"</tbody>";
            table_content.replaceWith($(content));
        },
        error:function(err){alert('Ocurrió un error');}
    });

    $(elm).addClass("selected");
}

function showEditActive(_cod,_desc,_precio,_cant,_cat){
    $("#modificar-activo").css("display","block");

    form=$('#edit-active');
    form.find('input[name=cod]').val(_cod);
    form.find('input[name=desc]').val(_desc);
    form.find('input[name=precio]').val(_precio);
    form.find('input[name=cant]').val(_cant);
    form.find('input[name=cant]').attr('max',_cant);

    options=$('categorias-edit > option');
    for(i=0;i<options.length;i++){
        if(options[i].val()===_cat){
            options[i].attr('selected','');
            break;
        }
    }
}

function showDeleteActive(_cod,_buenos,_regulares,_malos){
    $("#eliminar-activo").css("display","block");

    form=$('#delete-actives');
    form.find('input[name=cod]').val(_cod);
    form.find('.available-stat').text('Cant. Disponible: '+_buenos);
    form.find('input[name=cant]').attr('min','0');
    form.find('input[name=cant]').attr('max',_buenos);
    form.find('input[name=cantBuenos]').val(_buenos);
    form.find('input[name=cantRegular]').val(_regulares);
    form.find('input[name=cantMalos]').val(_malos);
}

function showAddActiveExist(_cod,_desc,_precio,total,_cat){
    $("#agregar-mas-activos").css("display","block");
    form=$('#add-more-actives');
    form.find('input[name=codigo]').val(_cod);
    form.find('input[name=descripcion]').val(_desc);
    form.find('input[name=precio]').val(_precio);
    form.find('input[name=subcategorias]').val(_cat);
}

function showAddActive(){
    $("#id-activo").css("display","block");
}

function eliminarCategoria(_id,e,str){
    alertify.confirm(
        "Eliminar Categoría",
        "¿Realmente desea eliminar esta "+str+"categoría?",
        function(){
            $.ajax({
                type:'post',
                url:'./controladoras/controladora_categoria.php',
                data:{IdCat:_id,consulta:'eliminarCategoria'},
                dataType:'json',
                success:function(resp){
                    if(resp.msg==='true'){
                        $(e).parent().fadeOut(500);
                        alertify.notify("Categoría eliminada","success",3);
                    }
                    else {alertify.notify("Ocurrió un error en la operación","error",3);}
                },
                error:function(err){alert('Ocurrió un error: '+err);}
            });
        },
        function(){}
    );
}

function eliminarActivos(idform){
    alertify.confirm(
        "Eliminar Activo",
        "¿Realmente desea eliminar estos activos?",
        function(){$('#'+idform).submit();},
        function(){});
    }

    function cambiarSubcategorias(_id,e){
        $(e).children().remove();
        $.ajax({
            type:'post',
            url:'./controladoras/controladora_categoria.php',
            data:{id:_id,consulta:'cargarSubcategorias'},
            dataType:'json',
            success:function(resp){
                for(i=0; i<resp.length;i++){
                    $(e).append($('<option value="'+resp[i][0]+'">'+resp[i][1]+'</option>'));
                }
            },
            error:function(err){alert('Ocurrió un error: '+err);}
        });
    }

    function cargarTablaTodos(elm){

        $('.aside-left .lead a').removeClass("selected");

        table_content=$('table.table-stock>tbody');
        table_content.empty();
        $.ajax({
            type:'post',
            url:'./controladoras/ActivosController.php',
            data:{consulta:'seleccionarActivos',ajax:'true'},
            dataType:'json',
            success:function(resp){
                content="";
                for(i=0; i<resp.length;i++){
                    content+="<tr>"+
                        "<td>"+resp[i][0]+"</td>"+
                        "<td>"+resp[i][1]+"</td>"+
                        "<td>"+resp[i][2]+"</td>"+
                        "<td>"+resp[i][3]+"</td>"+
                        "<td>"+resp[i][4]+"</td>"+
                        "<td>"+resp[i][5]+"</td>"+
                        "<td>"+resp[i][6]+"</td>"+
                        "<td>"+
                            "<ul class='options'>"+
                                "<li>"+
                                    "Opciones"+
                                    "<ul>"+
                                        "<li><button onclick='showEditActive(\""+resp[i][0]+"\",\""+resp[i][1]+"\",\""+resp[i][3]+"\",\""+resp[i][6]+"\")'>Modificar</button><li>"+
                                        "<li><button onclick='showEditActiveStatus(\""+resp[i][0]+"\",\""+resp[i][3]+"\",\""+resp[i][4]+"\",\""+resp[i][5]+"\")'>Cambiar Estado</button><li>"+
                                        "<li><button onclick='showDeleteActive(\""+resp[i][0]+"\",\""+resp[i][3]+"\",\""+resp[i][4]+"\",\""+resp[i][5]+"\")'>Eliminar</button><li>"+
                                    "</ul>"+
                                "</li>"+
                            "</ul>"+
                        "</td>"+
                    "</tr>";
                }
                content="<tbody>"+content+"</tbody>";
                table_content.replaceWith($(content));
            },
            error:function(err){alert('Ocurrió un error: '+err);}
        });

        $(elm).addClass("selected");
    }

    function cargarTabla(_id,_paTipo,elm){
        $('.aside-left .lead a').removeClass("selected");

        table_content=$('table.table-stock>tbody');
        table_content.empty();
        $.ajax({
            type:'post',
            url:'./controladoras/ActivosController.php',
            data:{subcategoria:_id,consulta:'selectPorCategoria2',paTipo:_paTipo},
            dataType:'json',
            success:function(resp){
                content="";
                for(i=0; i<resp.length;i++){
                    content+="<tr>"+
                        "<td>"+resp[i][0]+"</td>"+
                        "<td>"+resp[i][1]+"</td>"+
                        "<td>"+resp[i][2]+"</td>"+
                        "<td>"+resp[i][3]+"</td>"+
                        "<td>"+resp[i][4]+"</td>"+
                        "<td>"+resp[i][5]+"</td>"+
                        "<td>"+resp[i][6]+"</td>"+
                        "<td>"+
                            "<ul class='options'>"+
                                "<li>"+
                                    "Opciones"+
                                    "<ul>"+
                                        "<li><button onclick='showEditActive(\""+resp[i][0]+"\",\""+resp[i][1]+"\",\""+resp[i][3]+"\",\""+resp[i][6]+"\")'>Modificar</button><li>"+
                                        "<li><button onclick='showEditActiveStatus(\""+resp[i][0]+"\",\""+resp[i][3]+"\",\""+resp[i][4]+"\",\""+resp[i][5]+"\")'>Cambiar Estado</button><li>"+
                                        "<li><button onclick='showDeleteActive(\""+resp[i][0]+"\")'>Eliminar</button><li>"+
                                    "</ul>"+
                                "</li>"+
                            "</ul>"+
                        "</td>"+
                    "</tr>";
                }
                content="<tbody>"+content+"</tbody>";
                table_content.replaceWith($(content));
            },
            error:function(err){alert('Ocurrió un error: '+err);}
        });

        $(elm).addClass("selected");
    }

    function showEditActiveStatus(_cod,_buenos,_regulares,_malos){
        $("#modificar-activo-estado").css("display","block");
        form=$('#edit-active-status');
        form.find('input[name=cod]').val(_cod);
        form.find('.available-stat').text('Cant. Disponible: '+_buenos);
        form.find('input[name=cant]').attr('max',_buenos);
        form.find('input[name=cantBuenos]').val(_buenos);
        form.find('input[name=cantRegular]').val(_regulares);
        form.find('input[name=cantMalos]').val(_malos);
    }

    function cambiarEstados(elm,selector){
        form=$(selector);
        switch ($(elm).val()) {
            case 'b':
            form.find('.available-stat').text('Cant. Disponible: '+form.find('input[name=cantBuenos]').val());
            form.find('input[name=cant]').attr('max',form.find('input[name=cantBuenos]').val());
            break;
            case 'r':
            form.find('.available-stat').text('Cant. Disponible: '+form.find('input[name=cantRegular]').val());
            form.find('input[name=cant]').attr('max',form.find('input[name=cantRegular]').val());
            break;
            case 'm':
            form.find('.available-stat').text('Cant. Disponible: '+form.find('input[name=cantMalos]').val());
            form.find('input[name=cant]').attr('max',form.find('input[name=cantMalos]').val());
            break;
        }
    }



    /*function agregarActivo(idform){
        form=$('#'+idform);
        temp="";
        $.ajax({
            url:'controladoras/ActivosController.php',
            data:{consulta:'consultarActivo',codigo:form.find('input[name=codigo]').val()},
            type:'post',
            success:function(resp){
                temp=resp[0];
            },
            error:function(){alert('ocurrió un error');}
        });
        alert(temp);
        if(temp==='success'){form.submit();}
        else {alertify.notify('No se puede realizar la acción:<br>Ya existen activos con ese código.',"error",5);}
    }*/
