<?php

require_once 'database.php';

if (isset($_POST['consulta'])) {
    switch($_POST['consulta']) {

        case 'bodegaPrincipal':
            bodegaPrincipal();
        break;
    }
}

function bodegaPrincipal(){
    $conn = getConnection();
    $sql = "select *, (Disponibles + Reservados) as `Total` from tbbodega;";
    $result = $conn->query($sql);
    $activos = [];
    $cont = 0;

    while($row = $result->fetch_assoc()) {
        $activos[$cont][0] = $row['Codigo'];
        $activos[$cont][1] = $row['Total'];
        $activos[$cont][2] = $row['Disponibles'];
        $activos[$cont][3] = $row['Reservados'];
        $cont ++;
    }
    $conn->close();
    echo json_encode($activos);
}

?>
