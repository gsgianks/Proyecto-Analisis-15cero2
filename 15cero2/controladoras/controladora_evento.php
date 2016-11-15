<?php
require_once ("database.php");

	    if (isset($_POST['consulta'])) {
	        switch($_POST['consulta']) {

            case 'agregarEvento': //listo
                agregarEvento();
                break;
            case 'agregarActivosEvento': //listo
                agregarActivosEvento();
                break;
            case 'eliminarEvento': //listo
                eliminarEvento();
                break;
            case 'modificarEvento': //listo
                modificarEvento();
                break;
            }
            /*
            case 'seleccionarEvento': //listo
                seleccionarEvento();
                break;
            */
		}

	function agregarEvento(){

        $conn = getConnection();
        $sql = "call paAdministrarEvento(2,null,'".$_POST['nombreEven']."','".$_POST['fechaIni']."','".$_POST['fechaFin']."','".$_POST['ubicacion']."',".$_POST['cliente'].");";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $jsondata['Type'] = 'evento';
                $jsondata['Success'] = true;                
                $jsondata['Location'] = 'insertar_activo_evento.php?e='.$row['Id'].'&n='.$_POST['nombreEven'];              
            }else{
                $jsondata['Type'] = 'Evento';
                $jsondata['Success'] = false;
            } 
        $conn->close();
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($jsondata);
        exit();
    }

    function seleccionarEventos(){
        $conn = getConnection();
        $sql = "call paAdministrarEvento(1,null,null,null,null,null,null);";
        $result = $conn->query($sql);
        $eventos = null;
        $cont = 0;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $eventos[$cont][0] = $row['Id'];
                $eventos[$cont][1] = $row['Nombre'];
                $eventos[$cont][2] = $row['FechaInicio'];
                $eventos[$cont][3] = $row['FechaFinal'];
                $eventos[$cont][4] = $row['Ubicacion'];
                $eventos[$cont][5] = $row['Id_Cliente'];
                $eventos[$cont][6] = $row['NombreCli'];
                $cont ++;
            }
        } else {
            echo "no hay";
        }
        $conn->close();
        return $eventos;
    }

    function eliminarEvento(){
        $conn = getConnection();
        $sql = "call paAdministrarEvento(4,".$_POST['evento'].", null, null, null, null,null);";
        if ($conn->query($sql) === TRUE) {
            $json['Type'] = 'eliminarEvento';
            $json['Success'] = true;     
            $json['Evento'] = $_POST['evento'];                                        
        }
        else{
            $json['Type'] = 'eliminarEvento';
            $json['Success'] = false;
        }
        $conn->close();
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($json);
        exit();
    }

    function modificarEvento(){
        $conn = getConnection();
        $sql = "call paAdministrarEvento(3,".$_POST['idEvento'].", '".$_POST['nombreEven']."', '".$_POST['fechaIni']."', '".$_POST['fechaFin']."', '".$_POST['ubicacion']."',".$_POST['cliente'].");";
        if ($conn->query($sql) === TRUE) {
            $jsond['Type'] = 'modificarEvento';
            $jsond['Success'] = true;     
            $jsond['Evento'] = $_POST['idEvento'];
            $jsond['Nombre'] = $_POST['nombreEven'];
            $jsond['FechaIni'] = $_POST['fechaIni'];
            $jsond['FechaFin'] = $_POST['fechaFin'];
            $jsond['Cliente'] = $_POST['cliente'];
            $jsond['Ubicacion'] = $_POST['ubicacion'];
            $jsond['nombreCliente'] = $_POST['nombreCliente'];
        }
        else{
            $jsond['Type'] = 'modificarEvento';
            $jsond['Success'] = false;
        }
        $conn->close();
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($jsond);
        exit();
    }

    function seleccionarEvento($id){
        $conn = getConnection();
        $sql = "call paAdministrarEvento(5,".$id.",null,null,null,null,null);";
        $result = $conn->query($sql);
        $eventos = null;
        $cont = 0;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $eventos[$cont][1] = $row['Nombre'];
                $eventos[$cont][2] = $row['FechaInicio'];
                $eventos[$cont][3] = $row['FechaFinal'];
                $eventos[$cont][4] = $row['Ubicacion'];
                $eventos[$cont][6] = $row['NombreCli'];
                $cont ++;
            }
        } else {
            echo "no hay";
        }
        $conn->close();
        return $eventos;
    }
    /*
    function seleccionarEvento(){
        $conn = getConnection();
        $sql = "call paAdministrarEvento(".$_POST['id_event'].",null,null,null,null,null,null);";
        $result = $conn->query($sql);
        $eventos = null;
        $cont = 0;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $jsond['Type'] = 'cargarEvento';
                $jsond['Success'] = true;     
                $jsond['Evento'] = $row['Id'];
                $jsond['Nombre'] = $row['Nombre'];
                $jsond['FechaIni'] = $row['FechaInicio'];
                $jsond['FechaFin'] = $row['FechaFinal'];
                $jsond['Cliente'] = $row['Id_Cliente'];
                $jsond['Ubicacion'] = $row['Ubicacion'];
                $jsond['nombreCliente'] = $row['NombreCli'];;
            }
        } else {
            $jsond['Type'] = 'cargarEvento';
            $jsond['Success'] = false;  
        }
        $conn->close();
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($jsond);
        exit();
    }*/
?>
