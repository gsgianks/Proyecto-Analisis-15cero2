<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">

        <link rel="stylesheet" href="css/global.css">
        <link rel="stylesheet" href="css/activos.css">
        <link rel="stylesheet" href="js/css/alertify.min.css">
        <link rel="stylesheet" href="js/css/themes/default.min.css">

        <title>15 C E R O 2 | Bodega</title>
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
        <script type="text/javascript" src="js/bodega.js"></script>
    </body>

</html>
