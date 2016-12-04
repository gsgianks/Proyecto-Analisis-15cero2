<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">

        <link rel="stylesheet" href="css/global.css">
        <link rel="stylesheet" href="css/activos.css">
        <link rel="stylesheet" href="js/css/alertify.min.css">
        <link rel="stylesheet" href="js/css/themes/default.min.css">
        <link href="css/prueba.css" rel="stylesheet" type="text/css"/>

        <title>15 C E R O 2 | Activos</title>
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
                    <a style="padding:.5em">Agregar categoria</a>

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
                    <?php
                        $activos=seleccionarActivos(1,0);
                        $isEmpty=empty($activos);
                        if(!$isEmpty){
                    ?>
                    <button class="btn" onclick="showAddActive()"><span>+</span>Agregar nuevo activo</button>

                        <table class="table-stock">
                            <thead>
                                <tr>
                                    <th>Cód.</th>
                                    <th>Descripción</th>
                                    <th>Precio</th>
                                    <th>Buenos</th>
                                    <th>Regulares</th>
                                    <th>Malos</th>
                                    <th>Total</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                <!-- Recorrer el array de los activos -->
                                <?php for ($i=0; $i < count($activos); $i++) { ?>
                                <tr id="<?php echo $activos[$i][0]; ?>">
                                    <td><?php echo $activos[$i][0]; ?></td>
                                    <td><?php echo $activos[$i][1]; ?></td>
                                    <td><?php echo $activos[$i][2]; ?></td>
                                    <td><?php echo $activos[$i][3]; ?></td>
                                    <td><?php echo $activos[$i][4]; ?></td>
                                    <td><?php echo $activos[$i][5]; ?></td>
                                    <td><?php echo $activos[$i][6]; ?></td>
                                    <td><button type="button" onclick="showAddActiveExist('<?php echo $activos[$i][0]; ?>','<?php echo $activos[$i][1]; ?>','<?php echo $activos[$i][2]; ?>','<?php echo $activos[$i][6]; ?>','<?php echo $activos[$i][7]; ?>')">+</button></td>
                                    <td>
                                        <ul class="options">
                                            <li>
                                                Opciones
                                                <ul>
                                                    <li><button onclick="showEditActive('<?php echo $activos[$i][0]; ?>','<?php echo $activos[$i][1]; ?>','<?php echo $activos[$i][3]; ?>','<?php echo $activos[$i][6]; ?>')">Modificar</button></li>
                                                    <li><button onclick="showEditActiveStatus('<?php echo $activos[$i][0]; ?>','<?php echo $activos[$i][3]; ?>','<?php echo $activos[$i][4]; ?>','<?php echo $activos[$i][5]; ?>')">Cambiar Estado</button></li>
                                                    <li><button onclick="showDeleteActive('<?php echo $activos[$i][0]; ?>','<?php echo $activos[$i][3]; ?>','<?php echo $activos[$i][4]; ?>','<?php echo $activos[$i][5]; ?>')">Eliminar</button></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php } ?>
                        <div class="message-empty" style="display:<?php echo ($isEmpty)?'block':'none' ?>">
                                <p>
                                    No hay activos es este momento.<br>
                                    <span class="action">Haga click <button class="btn" type="button" onclick="showAddActive()">aquí</button> para agregar nuevos activos.</span><br>
                                    <span class="reminder">*Recuerde que es necesario que hayan categorías y subcategorías</span>
                                </p>
                        </div>
                    </div>
            </section>

            <footer>

            </footer>

        </div>


        <!--                      MODAL DE AGREGAR ACTIVOS   -------------------------->
        <div id="id-activo" class="modal">
            <!-- Modal Content -->
            <div class="modal-content animate">
                <span onclick="document.getElementById('id-activo').style.display='none'" class="close" title="Close Modal">&times;</span>
                <div class="div-modal-activo">
                <hr>
                    <div class="activo-form form agregar-activo">
                        <form id="add-active" class="agregar-activo" action="controladoras/ActivosController.php" method="post">
                            <input type="hidden" name="consulta" value="agregarActivo">
                            <h3>Agregar Activo</h3>
                            <hr>
                            <div class="form-group">
                                <input class="form-control" type="text" name="codigo" required placeholder="Codigo">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" name="descripcion" required placeholder="Descripcion">
                            </div>
                            <div class="form-group precio">
                                <input class="form-control" min="0" type="number" name="precio" required placeholder="Precio Unit.">
                            </div>
                            <div class="form-group cant">
                                <input class="form-control" min="0" type="number" name="cant" required placeholder="Cant.">
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
                                <select class="form-control" id="categorias-add" name="categoria" onchange="cambiarSubcategorias($(this).val(),$('select#subcategorias-add'))" oninvalid="this.setCustomValidity('Se necesita agregar una categoria')" required>
                                    <?php
                                        $_cats=cargarCategorias();
                                        $_fst_cat=$_cats[0][0];
                                        if(empty($_cats)){
                                            echo '<option value="">Sin categorías</option>';
                                        }
                                        else{
                                        foreach ($_cats as $categoria) {
                                    ?>
                                        <option value="<?php echo $categoria[0] ?>" ><?php echo $categoria[1]; ?></option>
                                    <?php } } ?>
                                </select>

                                <label for="subcategorias">Subcategoría</label>
                                <select class="form-control" id="subcategorias-add" name="subcategorias" required oninvalid="this.setCustomValidity('Se necesita agregar una subcategoria')">
                                    <?php
                                        $_subcats=cargarSubcategorias($_fst_cat,false);
                                        if(empty($_subcats)){
                                            echo '<option value="">Sin subcategorías</option>';
                                        }
                                        else{
                                        foreach ($_subcats as $_subcategoria) {
                                    ?>
                                        <option value="<?php echo $_subcategoria[0] ?>" ><?php echo $_subcategoria[1]; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                            <button class="btn btn-primary" type="submit">Agregar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--- FORMULARIO EDITAR ACTIVO -->
        <div id="modificar-activo" class="modal">
            <!-- Modal Content -->
            <div class="modal-content animate">
                <span onclick="document.getElementById('modificar-activo').style.display='none'" class="close" title="Close Modal">&times;</span>

                    <div class="activo-form form editar-activo">
                        <form class="editar-activo" action="controladoras/ActivosController.php" method="post" id="edit-active">
                            <input type="hidden" name="consulta" value="editarActivos">
                            <h3>Modificar Activo</h3>
                            <hr>
                            <div class="form-group">
                                <label for="cod">Código</label>
                                <span style="color:red; font-size:small">* Este campo no es editable</span>
                                <input class="form-control" type="text" name="cod" required readonly>
                            </div>
                            <div class="form-group">
                                <label>Descripcion</label>
                                <input class="form-control" type="text" name="desc" required placeholder="Descripcion">
                            </div>
                            <div class="form-group">
                                <label>Precio</label>
                                <input class="form-control" type="text" name="precio" required placeholder="Precio Unit.">
                            </div>
                            <div class="form-group">
                                <label>Categoría</label>
                                <select class="form-control" id="categorias-edit" name="categoria" required onchange="cambiarSubcategorias($(this).val(),$('select#subcategorias-edit'))">
                                    <?php
                                        $_cats_edit=cargarCategorias();
                                        $_fst_cat_edit=$_cats_edit[0][0];
                                        if(empty($_cats_edit)){
                                            echo '<option value="">Sin categorías</option>';
                                        }
                                        else{
                                        foreach ($_cats_edit as $categoria) {
                                    ?>
                                        <option value="<?php echo $categoria[0] ?>" ><?php echo $categoria[1]; ?></option>
                                    <?php } } ?>
                                </select>

                                <label>Subcategoría</label>
                                <select class="form-control" id="subcategorias-edit" name="subcategorias">
                                    <?php
                                        $_subcats=cargarSubcategorias($_fst_cat,false);
                                        if(empty($_subcats)){
                                            echo '<option value="">Sin subcategorías</option>';
                                        }
                                        else{
                                        foreach ($_subcats as $_subcategoria) {
                                    ?>
                                        <option value="<?php echo $_subcategoria[0] ?>" ><?php echo $_subcategoria[1]; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                            <button class="btn btn-primary" type="submit" >Guardar</button>
                        </form>
                    </div>
                    <!---------------------------------------------------------------------->
                    <!---------------------------------------------------------------------->
            </div>
        </div>

            <!--- FORMULARIO EDITAR ACTIVO ESTADO -->
            <div id="modificar-activo-estado" class="modal">
                <!-- Modal Content -->
                <div class="modal-content animate">
                    <span onclick="document.getElementById('modificar-activo-estado').style.display='none'" class="close" title="Close Modal">&times;</span>

                        <div class="activo-form form editar-activo">
                            <form class="editar-activo" action="controladoras/ActivosController.php" method="post" id="edit-active-status">
                                <input type="hidden" name="consulta" value="editarActivoEstado">
                                <input type="hidden" name="cantBuenos">
                                <input type="hidden" name="cantRegular">
                                <input type="hidden" name="cantMalos">
                                <h3>Cambiar Estado</h3>
                                <hr>
                                <div class="form-group">
                                    <label for="cod">Código</label>
                                    <span style="color:red; font-size:small">* Este campo no es editable</span>
                                    <input class="form-control" type="text" name="cod" readonly required>
                                </div>
                                <div class="form-group status">
                                    <label>Estado</label>
                                    <hr>
                                    <label for="estado">De</label>
                                    <select class="form-control" onchange="cambiarEstados(this'#edit-active-status')" name="prev_estado">
                                        <option value="b" selected>Bueno</option>
                                        <option value="r">Regular</option>
                                        <option value="m">Malo</option>
                                    </select>
                                    <label for="estado">A</label>
                                    <select class="form-control" name="estado">
                                        <option value="b">Bueno</option>
                                        <option value="r">Regular</option>
                                        <option value="m">Malo</option>
                                    </select>
                                    <hr>
                                </div>
                                <div class="form-group">
                                    <label class="available-stat">Cant. disponible:</label>
                                    <input class="form-control" type="number" name="cant" min="1">
                                </div>
                                <button class="btn btn-primary" type="submit" >Guardar</button>
                            </form>
                        </div>
                        <!---------------------------------------------------------------------->
                        <!---------------------------------------------------------------------->
                </div>
        </div>

        <!--- FORMULARIO ELIMINAR ACTIVO -->
        <div id="eliminar-activo" class="modal">
            <!-- Modal Content -->
            <div class="modal-content animate">
                <span onclick="document.getElementById('eliminar-activo').style.display='none'" class="close" title="Close Modal">&times;</span>

                    <div class="activo-form form editar-activo">
                        <form class="eliminar-activo" action="controladoras/ActivosController.php" method="post" id="delete-actives">
                            <input type="hidden" name="consulta" value="eliminarActivos">
                            <input type="hidden" name="cantBuenos">
                            <input type="hidden" name="cantRegular">
                            <input type="hidden" name="cantMalos">
                            <h3>Eliminar Activos</h3>
                            <hr>
                            <div class="form-group">
                                <label for="cod">Código</label>
                                <span style="color:red; font-size:small">* Este campo no es editable</span>
                                <input class="form-control" type="text" name="cod" readonly required>
                            </div>
                            <hr>
                            <div class="form-group status">
                                <label>Estado</label>
                                <select class="form-control" onchange="cambiarEstados(this,'#delete-actives')" name="estado">
                                    <option value="b" selected>Bueno</option>
                                    <option value="r">Regular</option>
                                    <option value="m">Malo</option>
                                </select>
                                <hr>
                            </div>
                            <div class="form-group">
                                <label class="available-stat">Cant. disponible:</label>
                                <input class="form-control" type="number" name="cant" min="1">
                            </div>
                            <button class="btn btn-primary" type="button" onclick="eliminarActivos('delete-actives')">Eliminar</button>
                        </form>
                    </div>
                    <!---------------------------------------------------------------------->
                    <!---------------------------------------------------------------------->
            </div>
    </div>

    <!--- FORMULARIO ELIMINAR ACTIVO -->
    <div id="agregar-mas-activos" class="modal">
        <!-- Modal Content -->
        <div class="modal-content animate">
            <span onclick="document.getElementById('agregar-mas-activos').style.display='none'" class="close" title="Close Modal">&times;</span>
                <div class="activo-form form editar-activo">
                    <form class="agregar-mas-activos" action="controladoras/ActivosController.php" method="post" id="add-more-actives">
                        <input type="hidden" name="consulta" value="agregarActivo">
                        <input type="hidden" name="codigo">
                        <input type="hidden" name="descripcion">
                        <input type="hidden" name="precio">
                        <input type="hidden" name="subcategorias">
                        <div class="form-group status">
                            <label>Agregar a estado</label>
                            <select class="form-control" name="estado">
                                <option value="b" selected>Bueno</option>
                                <option value="r">Regular</option>
                                <option value="m">Malo</option>
                            </select>
                            <hr>
                        </div>
                        <div class="form-group">
                            <label class="available-stat">Cant.</label>
                            <input class="form-control" type="number" min="1" name="cant">
                        </div>
                        <button class="btn btn-primary" type="submit">Agregar</button>
                    </form>
                </div>
                <!---------------------------------------------------------------------->
                <!---------------------------------------------------------------------->
        </div>
</div>

        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/alertify.min.js"></script>
        <script type="text/javascript" src="js/activos.js"></script>
    </body>

</html>
