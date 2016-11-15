<!DOCTYPE html>
<html>
<head>
	<title>Informe de evento</title>
	
	<link rel="stylesheet" href="css/informe.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/informe.js"></script>

</head>
<body>
<div class="main_content">

<?php
$hoy = getdate();
//print_r($hoy);
?>


	<?php require_once 'controladoras/controladora_evento.php'; $eventos = seleccionarEvento($_GET['e']); ?>
            	<p>Nombre: <?php echo $eventos[0][1]; ?></p>
            	<p>Fecha Inicio: <?php echo $eventos[0][2]; ?></p>
            	<p>Fecha Final: <?php echo $eventos[0][3]; ?></p>
            	<p>Ubicacion: <?php echo $eventos[0][4]; ?></p>
            	<p>Nombre Cliente: <?php echo $eventos[0][6]; ?></p>
            <?php require_once 'controladoras/controladora_evento_activo.php'; $activos = seleccionarActivosEventosInforme($_GET["e"]);
			if($activos != null){ ?>
				<h3>activos</h3>
	            <table id="informe_activos"  border="2">
		            <tr>
		                <td>Codigo</td>
		                <td>Descripcion</td>
		                <td>Precio</td>
		            </tr>
		            <?php for($i = 0;$i<count($activos);$i++){ ?>
		                <tr>
		                	<td><?php echo $activos[$i][2]; ?></td>
		                    <td><?php echo $activos[$i][0]; ?></td>
		                    <td><?php echo $activos[$i][1]; ?></td>              
	                	</tr> 
	            
            		<?php } ?>
            		<tr>
		                <td>Total</td>
		                <td></td>
		                <td></td>
		            </tr>
            	</table>  


			<?php }else{ ?>

				<h3>Activos necesarios</h3>
				<p>No hay activos asignados</p>
			<?php } ?>
</div>			
</body>
</html>