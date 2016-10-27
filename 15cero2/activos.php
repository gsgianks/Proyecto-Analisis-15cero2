<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">

        <link rel="stylesheet" href="css/global.css">
        <link rel="stylesheet" href="css/activos.css">
        <link rel="stylesheet" href="js/css/alertify.min.css">
        <link rel="stylesheet" href="js/css/themes/default.min.css">

        <title>15cero2 Eventos</title>
    </head>

    <body>
        <!--
            1- Cargar categorias.
            2- Cargar todos los activos por defecto
            3- Insertar activos
            4- Editar activos
        -->
        <div class="container main">
            <!-- Must be static file -->
            <?php
                include_once 'controladoras/ActivosController.php';
                include_once 'controladoras/controladora_categoria.php';
                include "_nav.php";
            ?>
            <section class="main_content">

                <aside class="aside-left categories">
                    <h3>Categorias</h3>
                    <hr>
                    <a href="#" onclick="showAddCategory()" style="padding:.5em">Agregar categoria</a>
                    <hr>
                    <ul class="lead">

                        <li ><a href="#" class="selected" onclick="cargarTablaTodos(this)">Todas los activos</a></li>
                            <?php
                                $categorias=cargarCategoriasRecursivo();
                                if(!empty($categorias)){
                                foreach ($categorias as $cats) {
                            ?>
                        <li>
                            <a href="#" onclick="cargarTabla(<?php echo $cats[0]; ?>,6,this)"><?php echo $cats[1];?></a>
                            <a  class="btn btn-default right" onclick="eliminarCategoria(<?php echo $cats[0]; ?>,this,'')" type="button" ><b>&times;</b></a>
                            <ul class="sub">
                            <?php foreach ($cats[3] as $subcats) { ?>
                                <li>
                                    <a href="#" onclick="cargarTabla(<?php echo $subcats[0]; ?>,5,this)"><?php echo $subcats[1]; ?></a>
                                    <a  class="btn btn-default right" onclick="eliminarCategoria(<?php echo $subcats[0]; ?>,this,'sub')" type="button" ><b>&times;</b></a>
                                </li><?php } ?>
                            </ul>
                        </li><?php } } ?>
                        <li id="sincategoria"><a href=# onclick="sincategoria(this)" >Sin categoria</a></li>
                    </ul>
                    <hr style="margin-top:.5em">

                    <!--- FORMULARIO AGREGAR CATEGORIA -->
                    <form class="add-category form" action="controladoras/controladora_categoria.php" method="post">
                        <div class="form-group">
                            <input type="hidden" name="consulta" value="agregarCategoria">
                            <input type="text" name="nombre" placeholder="Categoría o Subcategoría" required class="form-control">
                                <?php $categoriasSelect=cargarCategorias(); ?>
                                <select class="form-control" name="categoria" required>
                                    <option value="0" selected>-Ninguna-</option>
                                    <?php foreach($categoriasSelect as $categoria){ ?>
                                    <option value="<?php echo $categoria[0]; ?>"><?php echo $categoria[1]; ?></option> <?php } ?>
                                </select>
                        </div>
                        <button class="btn btn-primary" type="submit">Agregar</button>
                        <p style="color:red;margin-top:.5em">
                            *Si elige una categoría,<br> el campo insertado se tomará<br> como una
                            subcategoría.
                        </p>
                    </form>
                </aside>

                    <div class="table-stock-container">
                        <a href="#" onclick="showAddActive()">Agregar nuevo activo</a>
                        <table class="table-stock">
                            <thead>
                                <tr>
                                    <th>Cod.</th>
                                    <th>Descripcion</th>
                                    <th>Precio</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $activos=seleccionarActivos(1,0);
                                    if(!empty($activos)){
                                    for ($i=0; $i < count($activos); $i++) { ?>
                                <tr>
                                    <td><?php echo $activos[$i][1]; ?></td>
                                    <td><?php echo $activos[$i][3]; ?></td>
                                    <td><?php echo $activos[$i][4]; ?></td>
                                    <td>
                                        <a href="#" onclick="showEditActive('<?php echo $activos[$i][0]; ?>','<?php echo $activos[$i][1]; ?>','<?php echo $activos[$i][3]; ?>','<?php echo $activos[$i][4]; ?>')">Editar</a>
                                        <a href="#" onclick="eliminarActivo(<?php echo $activos[$i][0]; ?>,this)">Eliminar</a>
                                    </td>
                                </tr><?php } } else {echo "No hay activos en este momento";} ?>
                            </tbody>
                        </table>
                    </div>
                    <!--------------------------------------------------------------------------------------->
                    <!--------------------------------------------------------------------------------------->

                      <!--  FORMULARIO AGREGAR ACTIVO -->
                    <div class="activo-form form agregar-activo">
                        <form class="agregar-activo" action="controladoras/ActivosController.php" method="post">
                            <input type="hidden" name="consulta" value="agregarActivo">
                            <h3>Agregar Activo</h3>
                            <hr>
                            <div class="form-group">
                                <input class="form-control" type="text" name="codigo" required placeholder="Codigo">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" name="descripcion" required placeholder="Descripcion">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" name="precio" required placeholder="Precio Unit.">
                            </div>
                            <div class="form-group">
                                <label for="estado" class="">Estado</label>
                                <select class="form-control" name="estado" id="estado">
                                    <option value="b">Bueno</option>
                                    <option value="r">Regular</option>
                                    <option value="m">Malo</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="categorias">Categoría</label>
                                <select class="form-control" id="categorias-add" name="categoria" onchange="cambiarSubcategorias($(this).val(),$('select#subcategorias-add'))" required>
                                    <option value="addNew">-Agregar nueva categoria-</option>
                                    <?php foreach (cargarCategorias() as $categoria) { ?>
                                        <option value="<?php echo $categoria[0] ?>" ><?php echo $categoria[1]; ?></option>
                                    <?php } ?>
                                </select>

                                <label for="subcategorias">Subcategoría</label>
                                <select class="form-control" id="subcategorias-add" name="subcategorias" required oninvalid="this.setCustomValidity('Se necesita agregar una subcategoria')"></select>
                            </div>
                            <button class="btn btn-primary" type="submit" >Agregar</button>
                        </form>
                    </div>
                    <!----------------------------------------------------------------------->
                    <!----------------------------------------------------------------------->

                    <!--- FORMULARIO EDITAR ACTIVO -->
                    <div class="activo-form form editar-activo">
                        <form class="editar-activo" action="controladoras/ActivosController.php" method="post">
                            <input type="hidden" name="consulta" value="editarActivo">
                            <input type="hidden" name="id">
                            <h3>Modificar Activo</h3>
                            <hr>
                            <div class="form-group">
                                <input class="form-control" type="text" name="cod" required placeholder="Codigo">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" name="desc" required placeholder="Descripcion">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" name="precio" required placeholder="Precio Unit.">
                            </div>
                            <div class="form-group">
                                <label for="estado">Estado</label>
                                <select class="form-control" name="estado" id="estado">
                                    <option value="b">Bueno</option>
                                    <option value="r">Regular</option>
                                    <option value="m">Malo</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="categorias">Categoría</label>
                                <select class="form-control" id="categorias-edit" name="categoria" required onchange="cambiarSubcategorias($(this).val(),$('select#subcategorias-edit'))">
                                    <option value="addNew">-Agregar nueva categoria-</option>
                                <?php foreach (cargarCategorias() as $categoria) { ?>
                                    <option value="<?php echo $categoria[0] ?>" ><?php echo $categoria[1]; ?></option>
                                <?php } ?>
                                </select>

                                <label for="subcategorias">Subcategoría</label>
                                <select class="form-control" id="subcategorias-edit" name="subcategorias"></select>
                            </div>
                            <button class="btn btn-primary" type="submit" >Guardar</button>
                        </form>
                    </div>
                    <!---------------------------------------------------------------------->
                    <!---------------------------------------------------------------------->

            </section>

            <footer>

            </footer>

        </div>

        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/alertify.min.js"></script>
        <script type="text/javascript">
            $(document).ready(
                function(){
                    alertify.set('confirm','transition', 'fade');
                    alertify.set('notifier','position', 'top-right');
                    if($('.nav-alerts').text()!=''){alertify.notify($('.nav-alerts').text(),$('.nav-alerts').attr('type'),3);}
                    $('.form, .form>*').css({'visibility':'hidden'});

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
                $('.form,.form>*').css({'visibility':'hidden'});
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
                $('.form,.form>*').css({'visibility':'hidden'});
                $('.agregar-activo').css({'visibility':'initial'});
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

            function eliminarActivo(_id,e){
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
                                    $(e).parent().parent().fadeOut(1000);
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
        </script>
    </body>

</html>
