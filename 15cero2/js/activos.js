$(document).ready(
    function(){
        //$('.form, .form>*').css({'visibility':'hidden'});
        alertify.set('confirm','transition', 'fade');
        alertify.set('notifier','position', 'top-right');
        if($('.nav-alerts').text()!=''){alertify.notify($('.nav-alerts').text(),$('.nav-alerts').attr('type'),3);}
        
       // alert("hola");

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
                content+="<tr><td>"+resp[i][1]+"</td><td>"+resp[i][3]+"</td><td>"+resp[i][4]+"</td><td><a href='#' onclick='showEditActive()'>Editar</a><a href='#' onclick='eliminarActivo("+resp[i][0]+",this)'>Eliminar</a></td></tr>";
            }
            content="<tbody>"+content+"</tbody>";
            table_content.replaceWith($(content));
        },
        error:function(err){alert('Ocurrió un error');}
    });

    $(elm).addClass("selected");
}

function showAddCategory(){
    $('.form,.form>*').css({'visibility':'hidden'});
    $('.add-category, .add-category > *').css({'visibility':'initial'});
}

function showEditActive(_id,_cod,_desc,_precio){
    //$('.form,.form>*').css({'visibility':'hidden'});
    $("#modificar-activo").css("display","block");
    formulario=$('.editar-activo');

    formulario.css({'visibility':'initial'});
    formulario.find('input[name=id]').val(_id);
    formulario.find('input[name=cod]').val(_cod);
    formulario.find('input[name=desc]').val(_desc);
    formulario.find('input[name=precio]').val(_precio);

    $.ajax({
        type:'post',
        url:'./controladoras/controladora_categoria.php',
        data:{Id:_id,consulta:'cargarCategoria_y_Subcategoria'},
        dataType:'json',
        success:function(resp){
            formulario.find('select#categorias-edit>option[value='+resp.data['idCat']+']').attr('selected','selected');
            alert(resp.data['idCat']);
            $.ajax({
                type:'post',
                async:false,
                url:'./controladoras/controladora_categoria.php',
                data:{id:resp.data['idCat'],consulta:'cargarSubcategorias'},
                dataType:'json',
                success:function(subs){
                    option="";
                    alert(subs);
                    for(i=0; i<subs.length; i++){
                        option+="<option value='"+subs[i][0]+"'>"+subs[i][1]+"</option>";
                    }
                    alert(option);
                    $('select#subcategorias-edit').append(option);
                },
                error:function(err){alert('Ocurrió un error: '+err);}
            });
            formulario.find('select#subcategorias-edit>option[value='+resp.data['idSub']+']').attr('selected','selected');
            formulario.find('select#estado>option[value='+resp.data['estado']+']').attr('selected','selected');
        },
        error:function(err){alert('Ocurrió un error: '+err);}
    });

}
function showAddActive(){
    //alert("activo add");
    //$('.form,.form>*').css({'visibility':'hidden'});
    //$('.agregar-activo').css({'visibility':'initial'});
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
                        $(e).parent().fadeOut(1000);
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

function eliminarActivo(_id){
    alertify.confirm(
        "Eliminar Activo",
        "¿Realmente desea eliminar este activo?",
        function(){
            $.ajax({
                type:'post',
                url:'./controladoras/ActivosController.php',
                data:{id:_id,consulta:'eliminarActivo'},
                dataType:'json',
                success:function(resp){
                    if(resp.msg==='true'){
                        $('#'+_id).fadeOut(1000);
                        alertify.notify("Activo Eliminado","success",3);
                    }
                    else {alertify.notify("Ocurrió un error en la operación","error",3);}
                },
                error:function(err){alert('Ocurrió un error: '+err);}
            });
        },
        function(){});

        //alert($(e).attr('href'));
    }

    function cambiarSubcategorias(_id,e){
        $(e).children().remove();
        if(_id==='addNew'){showAddCategory();}
        else {
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
                    content+="<tr><td>"+resp[i][1]+"</td><td>"+resp[i][3]+"</td><td>"+resp[i][4]+"</td><td><a href='#' onclick='showEditActive()'>Editar</a><a href='#' onclick='eliminarActivo("+resp[i][0]+",this)'>Eliminar</a></td></tr>";
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
                for(i=0; i<resp.Activos.length;i++){
                    console.log(resp.Activos[i]);
                    content+="<tr><td>"+resp.Activos[i][1]+"</td><td>"+resp.Activos[i][3]+"</td><td>"+resp.Activos[i][4]+"</td><td><a href='#' onclick='showEditActive()'>Editar</a><a href='#' onclick='eliminarActivo("+resp.Activos[i][0]+",this)'>Eliminar</a></td></tr>";
                }
                content="<tbody>"+content+"</tbody>";
                table_content.replaceWith($(content));
            },
            error:function(err){alert('Ocurrió un error: '+err);}
        });

        $(elm).addClass("selected");
    }
