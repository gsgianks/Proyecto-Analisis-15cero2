<!DOCTYPE html>
<html>
<head>
	<title>Insertar Cliente</title>
	<link rel="stylesheet" href="css/global.css">
	<link rel="stylesheet" href="css/newStyle.css">
    <link rel="stylesheet" href="css/activos.css">
    <link rel="stylesheet" href="js/css/alertify.min.css">
    <link rel="stylesheet" href="js/css/themes/default.min.css">
    <link href="css/prueba.css" rel="stylesheet" type="text/css"/>


</head>

<body>

	<?php include "_nav.php" ?>

	<div class="main_content">
		<aside class="aside-left">
            <section class="aside-content">
    			<section class="formulario">
    				<h1>Insertar Cliente</h1>
    				<form action="controladoras/controladora_cliente.php" method="post">
    					<input type="hidden" name="consulta" value="agregarCliente">
    					<input type="hidden" name="idCliente">
    					<input type="hidden" name="donde" value="clientes">
    					<div class="form-group"><label>Nombre:</label><br><input class="form-control" type="text" name="nombre" required></div>
    					<div class="form-group"><label>Correo:</label><br><input class="form-control" type="email" name="correo" required></div>
    					<div class="form-group"><label>Direcci&oacute;n</label><br><input class="form-control" type="text" name="direccion" required></div>
    					<div class="form-group"><label>Telefono</label><br><input class="form-control" type="text" name="telefono" required></div>
    					<button class="submit btn btn-primary" type="submit">Agregar</button> 
    				</form>
    			</section>
            </section>
		</aside>

		<section class="lista-clientes">
        <h3>Clientes registados</h3>
            <?php require_once 'controladoras/controladora_cliente.php'; $clientes = cargarClientes();
            if($clientes != null){?>
                <table id="table-clientes">
                 <thead>
                <tr>
                    <td>Nombre</td>
                    <td>Correo</td>
                    <td>Telefono</td>
                    <td>Direccion</td>
                    <td>Opciones</td>
                </tr>
                </thead>
                <?php for($i = 0;$i<count($clientes);$i++){?>
                    <tr class="opciones">
                        <td style='display: none;'><?php echo $clientes[$i][0]; ?></td>
                        <td><?php echo $clientes[$i][1]; ?></td>
                        <td><?php echo $clientes[$i][2]; ?></td>
                        <td><?php echo $clientes[$i][3]; ?></td>
                        <td><?php echo $clientes[$i][4]; ?></td>
                        <td>
                            <ul class="options">
                                <li><p>Opciones</p>
                                    <ul>
                                        <li><button onclick="modificarCliente(<?php echo $clientes[$i][0]; ?>);">Modificar</button></li>
                                        <li><button onclick="eliminarCliente(<?php echo $clientes[$i][0]; ?>);">Eliminar</button></li>
                                    </ul>
                                </li>
                            </ul>
                        </td>
                    </tr>

                <?php }?>
                </table>

            <?php }else{ ?>

                <p>No hay clientes registrados</p>

            <?php }?>

    </section>
  </div>
<div id="modal-editar-cliente" class="modal">
    <!-- Modal Content -->
    <div class="modal-content animate">
        <span onclick="document.getElementById('modal-editar-cliente').style.display='none'" class="close" title="Close Modal">&times;</span>
        <div class="div-editar-cliente">
            <section class="formulario">
                    <h1>Modificar Cliente</h1>
                    <hr>
                    <form action="controladoras/controladora_cliente.php" method="post">
                        <input type="hidden" name="consulta" value="modificarCliente">
                        <input type="hidden" name="idCliente">
                        <input type="hidden" name="donde" value="clientes">
                        <div class="form-group"><label>Nombre:</label><br><input class="form-control" type="text" name="nombre" required></div>
                        <div class="form-group"><label>Correo:</label><br><input class="form-control" type="email" name="correo" required></div>
                        <div class="form-group"><label>Direcci&oacute;n</label><br><input class="form-control" type="text" name="direccion" required></div>
                        <div class="form-group"><label>Telefono</label><br><input class="form-control" type="text" name="telefono" required></div>
                        <button class="submit btn btn-primary" type="submit">Modificar</button> 
                    </form>
            </section>
        </div>
    </div>
</div>

    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/agregarCliente.js"></script>
    <script type="text/javascript" src="js/formulario.js"></script>
    <script type="text/javascript" src="js/alertify.min.js"></script>
</body>
</html>















<!-- </td><td><ul class="options"><li><p>Opciones</p><ul><li><button onclick="modificarCliente('+id+');">Modificar</button></li><li><button onclick="eliminarCliente('+id+');">Eliminar</button></li></ul></li></ul></td> !>