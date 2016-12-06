<!DOCTYPE html>
<html>
<head>
	<title>Factura de evento</title>
	
	<link rel="stylesheet" href="css/informe.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/factura.js"></script>

</head>
<body>
<div class="main_content">

<?php
date_default_timezone_set("America/Costa_Rica");
$hoy = getdate();
?>


	<?php require_once 'controladoras/controladora_evento.php'; $eventos = seleccionarEvento($_GET['e']); ?>

				<a href="InsertarEvento.php"><img src="css/volver.png" height="40" width="40" title="volver"></a>

				<h3 class="left">15cero2</h3>
				<p class="right">Fecha: <?php echo $hoy['mday']."/".$hoy['mon']."/".$hoy['year'];?></p>
            	<hr style="clear: both;">
            	<div><h1>Nombre: <?php echo $eventos[0][1]; ?></h1></div>
            	<hr>
            	<div class="left">
            		<p>Nombre Cliente: <?php echo $eventos[0][6]; ?></p>
            		<p>Empleado: <?php session_start(); echo $_SESSION['user']; ?></p>
            	</div>
            	<div class="right">
            		<label>Descuento</label><br>
            		<input id="descuento" type="number" placeholder="el descuento es en %"><br>
            		<button onclick="descuento()">Aplicar</button>
            	</div>
            <?php require_once 'controladoras/controladora_factura.php'; $factura = selectFactura($_GET["e"]); $servicios = selectServicios($factura); ?>
            <?php require_once 'controladoras/controladora_evento_activo.php'; $activos = seleccionarActivosEventosInforme($_GET["e"]);
			if($activos != null || $servicios != null){ ?>
				<h3 id="detail_event">Detalle del evento</h3>
	            <table id="informe_activos"  border="2">
		            <tr>
		                <td>Codigo</td>
		                <td>Descripcion</td>
		                <td>Cantidad</td>
		                <td>Precio Unitario</td>
		                <td>Total</td>
		            </tr>
		            <?php for($i = 0;$i<count($servicios);$i++){ ?>
		                <tr>
		                	<td>Serv</td>
		                    <td><?php echo $servicios[$i][0]; ?></td>
		                    <td>1</td>
		                    <td><?php echo $servicios[$i][1]; ?></td>
		                    <td></td> 
	                	</tr>
            		<?php } ?>
		            <?php for($i = 0;$i<count($activos);$i++){ ?>
		                <tr>
		                	<td><?php echo $activos[$i][1]; ?></td>
		                	<td><?php echo $activos[$i][2]; ?></td>
		                    <td><?php echo $activos[$i][3]; ?></td>
		                    <td><?php echo $activos[$i][0]; ?></td>
		                    <td></td>              
	                	</tr> 
	            
            		<?php } ?>
            		<tr>
		                <td>Total</td>
		                <td></td>
		                <td></td>
		                <td></td>
		                <td id="total"></td>
		            </tr>
            	</table>  


			<?php }else{ ?>

				<h3>Activos necesarios</h3>
				<p>No hay activos asignados</p>
			<?php } ?>
</div>			
</body>
</html>