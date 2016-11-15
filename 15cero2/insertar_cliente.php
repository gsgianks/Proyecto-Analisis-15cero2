<!DOCTYPE html>
<html>
<head>
	<title>Insertar Cliente</title>
	<link rel="stylesheet" href="css/global.css">
	<link rel="stylesheet" href="css/newStyle.css">
    <link rel="stylesheet" href="js/css/alertify.min.css">
    <link rel="stylesheet" href="js/css/themes/default.min.css">


</head>

<body>

	<?php include "_nav.php" ?>

	<div class="main_content">
		<aside>
			<section class="formulario">
				<h1>Insertar Cliente</h1>
				<form action="controladoras/controladora_cliente.php" method="post">
					<input type="hidden" name="consulta" value="agregarCliente">
					<input type="hidden" name="idCliente">
					<input type="hidden" name="donde" value="clientes">
					<label>Nombre:</label><br><input type="text" name="nombre">
					<label>Correo:</label><br><input type="email" name="correo">
					<label>Direcci&oacute;n</label><br><input type="text" name="direccion">
					<label>Telefono</label><br><input type="text" name="telefono">
					<input class="submit" type="submit" value="Agregar">
				</form>
			</section>
		</aside>
		<section class="lista-clientes">
        <h3>Clientes registados</h3>
            <?php require_once 'controladoras/controladora_cliente.php'; $clientes = cargarClientes();
            if($clientes != null){?>
                <table id="table-clientes" border="2">
                <tr>
                    <td>Nombre</td>
                    <td>Correo</td>
                    <td>Telefono</td>
                    <td>Direccion</td>
                    <td>Opciones</td>
                </tr>
                <?php for($i = 0;$i<count($clientes);$i++){?>
                    <tr class="opciones">
                        <td style='display: none;'><?php echo $clientes[$i][0]; ?></td>
                        <td><?php echo $clientes[$i][1]; ?></td>
                        <td><?php echo $clientes[$i][2]; ?></td>
                        <td><?php echo $clientes[$i][3]; ?></td>
                        <td><?php echo $clientes[$i][4]; ?></td>
                        <td><button style="color: black;" onclick="modificarCliente(<?php echo $clientes[$i][0]; ?>);">Modificar</button><button style="color: black;" onclick="eliminarCliente(<?php echo $clientes[$i][0]; ?>);">Eliminar</button></td>
                    </tr>

                <?php }?>
                </table>

            <?php }else{ ?>

                <p>No hay clientes registrados</p>

            <?php }?>

    </section>
  </div>
	</div>

    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/agregarCliente.js"></script>
    <script type="text/javascript" src="js/formulario.js"></script>
    <script type="text/javascript" src="js/alertify.min.js"></script>
</body>
</html>
