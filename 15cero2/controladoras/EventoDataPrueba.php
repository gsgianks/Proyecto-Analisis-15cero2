<?php

require_once 'database.php';
include_once 'dominio/Evento.php';

class EventoDataPrueba{

	//Funcion para insertar un activo
	function insertarEvento($activo){

		$resul = 'false';
		$conn = getConnection();
        $sql = "call paAdministrarEvento(2,null,'".$activo->nombre."','".$activo->fechaInicio."','".$activo->fechaFinal."','".$activo->ubicacion."',".$activo->idCliente.");";
        if ($conn->query($sql) == TRUE) {
        	$resul = 'true';
        }
        $conn->close();
        echo $resul.'  resul';
		return $resul;
	}

	//Funcion para modificar un activo
	function modificarEvento($activo){

		$resul = 'false';
		$conn = getConnection();
        $sql = "call paAdministrarEvento(3,".$activo->id.",'".$activo->nombre."','".$activo->fechaInicio."','".$activo->fechaFinal."','".$activo->ubicacion."',".$activo->idCliente.");";
        if ($conn->query($sql) === TRUE) {
        	$resul = 'true';
        }
        $conn->close();

		return $resul;
	}
	//Funcion para eliminar un activo
	function eliminarEvento($id){

		$resul = 'false';
		$conn = getConnection();
        $sql = "call paAdministrarEvento(4,".$id.",null,null,null,null,null);";
        if ($conn->query($sql) === TRUE) {
        	$resul = 'true';
        }
        $conn->close();

		return $resul;
	}

	//Funcion para consultar un activo
	function consultarEvento($nombre){

		$conn = getConnection();

		echo "call paAdministrarEvento(5,null,'".$nombre."',null,null,null,null);";
		$sql = "call paAdministrarEvento(5,null,'".$nombre."',null,null,null,null);";
		$result = $conn->query($sql);
		$evento = new Evento();

		if ($result->num_rows > 0) {
		    $row = $result->fetch_assoc();

			$evento->id = $row['Id'];
			$evento->nombre = $row['Nombre'];
			$evento->fechaInicio = $row['FechaInicio'];
			$evento->fechaFinal = $row['FechaFinal'];
			$evento->ubicacion = $row['Ubicacion'];
			$evento->idCliente = $row['Id_Cliente'];
		}

		$conn->close();
		return $evento;
	}
}

?>
