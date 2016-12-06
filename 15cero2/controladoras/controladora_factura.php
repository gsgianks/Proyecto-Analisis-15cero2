<?php 
require_once ("database.php");

        if (isset($_POST['consulta'])) {
            switch($_POST['consulta']) {

            case 'agregarServicio': //listo
                agregarServicio();
                break;
        }
    }

function agregarServicio(){
        $conn = getConnection();
        $sql = "call paAdministrarServicios(2, null,".$_POST['evento'].",'".$_POST['servicio']."',".$_POST['costo'].");";
        //$jsondata['Consulta'] = "call paAdministrarServicios(2, null,".$_POST['evento'].",'".$_POST['servicio']."', ".$_POST['costo'].");";
        if ($conn->query($sql) === TRUE) {
            $jsondata['Success'] = true;
        }else{
            $jsondata['Success'] = false;
        }
        $jsondata['Type'] = 'agregarServicio';
        $conn->close();
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($jsondata);
        exit();
}

function selectFactura($event){
        $conn = getConnection();
        $sql = "call paAdministrarFactura(2, null, ".$event.", null, null, null, null, null)";
        $result = $conn->query($sql);
        $evento = null;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $evento = $row['Id'];
            }
        } else {
            echo 'no encontro el codigo';
        }
        $conn->close();
        return $evento;
    }

    function selectServicios($fact){
        $conn = getConnection();
        $sql = "call paAdministrarServicios(1, null, ".$fact.", null, null)";
        $result = $conn->query($sql);
        $services = null;
        $cont = 0;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $services[$cont][0] = $row['Nombre'];
                $services[$cont][1] = $row['Precio'];
                $cont++;
            }
        }
        
        $conn->close();
        return $services;
    }

?>