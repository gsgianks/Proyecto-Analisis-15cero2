<!DOCTYPE html>
<html>
<head>
	<title>prueba</title>

	<link rel="stylesheet" href="js/css/alertify.min.css">

	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/agregarCliente.js"></script>
	<script type="text/javascript" src="js/alertify.min.js"></script>
</head>
<body>
<?php require_once 'controladoras/controladora_evento.php'; $eventos = seleccionarEventos(); ?>
            
                    <a onclick="cargarEvento(<?php echo $eventos[0][0]; ?>)"><?php echo $eventos[0][1]; ?></a>
                   
            

</body>
</html>



