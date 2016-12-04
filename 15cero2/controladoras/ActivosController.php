<?php

require_once 'database.php';

if (isset($_POST['consulta'])) {
    switch($_POST['consulta']) {

        case 'agregarActivo':
        agregarActivo();
        break;
        case 'eliminarActivos':
        eliminarActivos();
        case 'selectPorCategoria':
        selectPorCategoria();
        break;
        case 'selectPorCategoria2':
        selectPorCategoria2();
        break;
        case 'editarActivos':
        editarActivos();
        break;
        case 'editarActivoEstado':
        editarActivoEstado();
        /*case 'consultarActivo':
        consultarActivo();
        break;*/
        case 'seleccionarActivos':
        seleccionarActivos(1,0);
        break;
        case 'seleccionarSinCategoria':
        seleccionarSinCategoria();
        break;
    }
}

function seleccionarSinCategoria(){
    //echo "agregarActivo";
    $conn = getConnection();
    //1- Select
    //2- InsertarActivo
    $sql = "call paAdministrarArticulo(8,null,null,null,null,null,null);";
    $result = $conn->query($sql);
    $activos = [];
    $cont = 0;

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $activos[$cont][0] = $row['Codigo'];
            $activos[$cont][1] = $row['Descripcion'];
            $activos[$cont][2] = $row['Precio'];
            $activos[$cont][3] = $row['Buenos'];
            $activos[$cont][4] = $row['Regulares'];
            $activos[$cont][5] = $row['Malos'];
            $activos[$cont][6] = $row['Total'];
            $activos[$cont][7] = $row['sub'];
            $cont ++;
        }

        $conn->close();
        if(isset($_POST['ajax'])){echo json_encode($activos);}
        else{return $activos;}
    }
    else {
        if(isset($_POST['ajax'])){echo json_encode($activos);}
        else{return $activos;}
    }
}

function editarActivoEstado(){
    //echo "agregarActivo";
    $conn = getConnection();
    //1- Select
    //2- InsertarActivo
    $sql = "call paAdministrarArticulo(3,".$_POST['cant'].",'".$_POST['cod']."',null,null,null,'".$_POST['prev_estado'].$_POST['estado']."');";
    //echo "call paAdministrarArticulo(3,".$_POST['cant'].",'".$_POST['cod']."',null,null,null,'".$_POST['prev_estado'].$_POST['estado']."');";

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        header('Location: ../activos.php?msg=success');
    }
    else{
        $conn->close();
        header('Location: ../activos.php?msg=error');
    }
}

function editarActivos(){
    //echo "agregarActivo";
    $conn = getConnection();
    //1- Select
    //2- InsertarActivo
    $sql = "call paAdministrarArticulo(9,null,'".$_POST['cod']."',".$_POST['subcategorias'].",'".$_POST['desc']."',".$_POST['precio'].",null);";

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        header('Location: ../activos.php?msg=success');
    }
    else{
        $conn->close();
        header('Location: ../activos.php?msg=error');
    }
}

/*function consultarActivo(){

    //echo "agregarActivo";
    //1- Select
    $conn = getConnection();
    //2- InsertarActivo

    $sql = "call paAdministrarArticulo(10,null,'".$_POST['codigo']."',null,null,null,null);";

    $cont = 0;
    $consulta=null;
    $result=$conn->query($sql);
    while($row = $result->fetch_assoc()) {
        $consulta = $row['result'];
    }
    $conn->close();

    if($consulta==='0'){
        header('Content-type: application/json; charset=utf-8');
        echo json_encode(["success"]);
    }
    else{
        header('Content-type: application/json; charset=utf-8');
        echo json_encode(["error"]);
    }
}*/

function agregarActivo(){
    $conn = getConnection();

    for($i=0;$i<$_POST['cant'];$i++){
        $sql = "call paAdministrarArticulo(2,null,'".$_POST['codigo']."',".$_POST['subcategorias'].",'".$_POST['descripcion']."',".$_POST['precio'].",'".$_POST['estado']."');";
        if ($conn->query($sql) != TRUE) {
            $conn->close();
            header('Location: ../activos.php?msg=error');
        }
    }
    $conn->close();
    header('Location: ../activos.php?msg=success');
}

function eliminarActivos(){
    $conn=getConnection();
    $sql="call paAdministrarArticulo(4,".$_POST['cant'].",'".$_POST['cod']."',null,null,null,'".$_POST['estado']."');";

    echo "call paAdministrarArticulo(4,".$_POST['cant'].",'".$_POST['cod']."',null,null,null,'".$_POST['estado']."');";

    if($conn->query($sql)===TRUE){
        $conn->close();
        header('Location: ../activos.php?msg=success');
    }
    else{
        $conn->close();
        header('Location: ../activos.php?msg=error');
    }

    /*echo json_encode($dataResponse);
    exit();*/
}

function seleccionarActivos($identificador, $categoria){

    $conn = getConnection();
    $sql = "call paAdministrarArticulo(".$identificador.",null,null,".$categoria.",null,null,null);";
    $result = $conn->query($sql);
    $activos = [];
    $cont = 0;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $activos[$cont][0] = $row['Codigo'];
            $activos[$cont][1] = $row['Descripcion'];
            $activos[$cont][2] = $row['Precio'];
            $activos[$cont][3] = $row['Buenos'];
            $activos[$cont][4] = $row['Regulares'];
            $activos[$cont][5] = $row['Malos'];
            $activos[$cont][6] = $row['Total'];
            $activos[$cont][7] = $row['sub'];
            $cont ++;
        }

        $conn->close();
        if(isset($_POST['ajax'])){echo json_encode($activos);}
        else{return $activos;}
    }
    else {
        if(isset($_POST['ajax'])){echo json_encode($activos);}
        else{return $activos;}
    }

}

function selectPorCategoria2(){

    $conn = getConnection();
    $sql = "call paAdministrarArticulo(".$_POST['paTipo'].",null,null,".$_POST['subcategoria'].",null,null,null);";
    $result = $conn->query($sql);
    $activos = [];
    $cont = 0;

    while($row = $result->fetch_assoc()) {
        $activos[$cont][0] = $row['Codigo'];
        $activos[$cont][1] = $row['Descripcion'];
        $activos[$cont][2] = $row['Precio'];
        $activos[$cont][3] = $row['Buenos'];
        $activos[$cont][4] = $row['Regulares'];
        $activos[$cont][5] = $row['Malos'];
        $activos[$cont][6] = $row['Total'];
        $activos[$cont][7] = $row['sub'];
        $cont ++;
    }

    $conn->close();
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($activos);
    exit();
}

function selectPorCategoria(){

    $conn = getConnection();
    $sql = "call paAdministrarArticulo(".$_POST['identificador'].",null,null,".$_POST['categoria'].",null,null,null);";
    $result = $conn->query($sql);
    $activos = null;
    $cont = 0;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $activos[$cont][0] = $row['Id'];
            $activos[$cont][1] = $row['Codigo'];
            $activos[$cont][2] = $row['Id_Categoria'];
            $activos[$cont][3] = $row['Descripcion'];
            $activos[$cont][4] = $row['Precio'];
            $activos[$cont][5] = $row['Estado'];
            $cont ++;
        }
        $json['Type'] = 'selectPorCategoria';//here
        $json['Success'] = true;
        $json['Activos'] = $activos;
    }else{
        $json['Type'] = 'selectPorCategoria';
        $json['Success'] = false;
    }
    $conn->close();
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($json);
    exit();
}
?>
