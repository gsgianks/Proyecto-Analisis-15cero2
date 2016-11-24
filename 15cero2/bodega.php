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
        <!-- Tasks
        -->
        <div class="container main">
            <!-- Must be static file -->
            <?php
            include_once 'controladoras/ActivosController.php';
            include_once 'controladoras/controladora_categoria.php';
            include "_nav.php";
            ?>
            <section class="main_content">

                <aside class="aside-left">
                    <h3>Búsqueda por activo</h3>
                    <hr>
                    <!--<a href="#" onclick="showAddCategory()" style="padding:.5em">Agregar categoria</a>
                    <hr>-->
                    <form>
                        <div class="form-group">
                            <input name="search" type="search" class="form-control" placeholder="Código...">
                            <button class="btn btn-primary" type="button">Buscar</button>
                        </div>
                    </form>
                    <hr style="margin-top:.5em">
                    <h3>Bodega</h3>
                    <hr>
                    <ul class="lead">
                        <li>Bodega Principal</li>
                    </ul>
                    <hr style="margin-top:.5em">
                    <h3>Bodegas por evento</h3>
                    <hr>
                    <ul class="lead">
                        <li>Nombre evento 1</li>
                        <li>Nombre evento 2</li>
                    </ul>
                    <hr style="margin-top:.5em">
                </aside>

                <div class="table-stock-container">
                    <!--<a href="#" onclick="showAddActive()">Agregar nuevo activo</a>-->
                    <table class="table-warehouse">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Disponible/s</th>
                                <th>Reservado/s</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="replaceable">
                        </tbody>
                    </table>
                </div>
                <!--------------------------------------------------------------------------------------->
                <!--------------------------------------------------------------------------------------->
            </section>

            <footer>

            </footer>

        </div>

        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/alertify.min.js"></script>
        <script type="text/javascript" src="js/bodega.js"></script>
    </body>

</html>
