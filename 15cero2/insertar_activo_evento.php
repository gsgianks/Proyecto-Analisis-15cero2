<!DOCTYPE html>
<html>
<head>
	<title>Insertar Activo a Evento</title>
	<link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/newStyle.css">
    <link rel="stylesheet" href="css/activos.css">
    <link rel="stylesheet" href="js/css/alertify.min.css">
    <link rel="stylesheet" href="js/css/themes/default.min.css">

    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/formulario.js"></script>
    <script type="text/javascript" src="js/agregarCliente.js"></script>
    <script type="text/javascript" src="js/alertify.min.js"></script>

</head>
<body>
	<?php include "_nav.php" ?>
	<div class="main_content">
		<aside class="aside-left">
            <section class="aside-content">
    			<section class="formulario">
    				
					<h1>Insertar Activos a Evento</h1>
					<form action="controladoras/controladora_evento_activo.php" method="post">

						<input type="hidden" name="evento" value='<?php echo $_GET["e"] ?>'>
				        <input type="hidden" name="consulta" value='agregarActivosEvento'>
				        <div class="form-group"><label>Categorias:</label><br>
				        <select class="form-control" id="categorias" name="categoria">
				        	<option value="0">--Seleccione--</option>
				        	<?php require_once 'controladoras/controladora_categoria.php'; $Categorias = cargarCategorias2();
							for($i = 0; $i<count($Categorias);$i++){ ?>
								<option value="<?php echo $Categorias[$i][0]?>"><?php echo $Categorias[$i][1]?></option>
							<?php } ?>
				        </select></div>
				        <div class="form-group"><label>Activo: </label><br>
						<select class="form-control" id="activos" name="activo">
							<option value="0">-- No hay activos --</option>
						</select></div>
						<div class="form-group"><label>Cantidad:</label><br>
						<input class="form-control" id="cantidad_activos" type="number" name="cantidad" required><div class="form-group">
						Disponibles: <label style="color: blue;" id="cantidad_maxima"></label><br>
						<button class="submit btn btn-primary" type="submit">Agregar</button> 
					</form>
					
    			</section>
            </section>
		</aside>
		<h3 id="Event">Nombre evento:<?php echo $_GET['n'] ?></h3>
		<div class="activos-necesarios">
			
			<?php require_once 'controladoras/controladora_evento_activo.php'; $eventos = seleccionarActivosEventosArray($_GET["e"]);
			if($eventos != null){ ?>
				<h3>Eventos</h3>
	            <table id="table">
	            <thead>
		            <tr>
		                <td>Id</td>
		                <td>Nombre</td>
		                <td>Cantidad</td>
		                <td>Acci&oacute;n</td>
		            </tr>
		            </thead>
		            <?php for($i = 0;$i<count($eventos);$i++){ ?>
		                <tr>
		                	<td><?php echo $eventos[$i][2]; ?></td>
		                    <td><?php echo $eventos[$i][0]; ?></td>
		                    <td><?php echo $eventos[$i][1]; ?></td>
		                    <td><button style="color: black;" name="<?php echo $eventos[$i][2]; ?>" onClick="eliminarActivoEvento(this)">Eliminar</button></td>
	                	</tr>

            		<?php } ?>
            	</table>


			<?php }else{ ?>

				<h3>Activos necesarios</h3>
				<p>No hay activos asignados</p>


			<?php } ?>


		</div>


	</div>
</body>
</html>
