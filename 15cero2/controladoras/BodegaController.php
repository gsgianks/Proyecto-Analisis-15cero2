<?php

require_once 'database.php';

if (isset($_POST['consulta'])) {
    switch($_POST['consulta']) {

        case 'agregarActivo':
        agregarActivo();
        break;
        case 'eliminarActivo':
        eliminarActivo();
        case 'selectPorCategoria':
        selectPorCategoria();
        break;
        case 'selectPorCategoria2':
        selectPorCategoria2();
        break;
        case 'editarActivo':
        editarActivo();
        break;
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
            $activos[$cont][0] = $row['Id'];
            $activos[$cont][1] = $row['Codigo'];
            $activos[$cont][2] = $row['Id_Categoria'];
            $activos[$cont][3] = $row['Descripcion'];
            $activos[$cont][4] = $row['Precio'];
            $activos[$cont][5] = $row['Estado'];
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

function editarActivo(){
    //echo "agregarActivo";
    $conn = getConnection();
    //1- Select
    //2- InsertarActivo
    $sql = "call paAdministrarArticulo(3,".$_POST['id'].",'".$_POST['cod']."',".$_POST['subcategorias'].",'".$_POST['desc']."',".$_POST['precio'].",'".$_POST['estado']."');";

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        header('Location: ../activos.php?msg=success');
    }
    else{
        $conn->close();
        header('Location: ../activos.php?msg=error');
    }
}

function agregarActivo(){

    //echo "agregarActivo";
    $conn = getConnection();
    //1- Select
    //2- InsertarActivo
    $sql = "call paAdministrarArticulo(2,null,'".$_POST['codigo']."',".$_POST['subcategorias'].",'".$_POST['descripcion']."',".$_POST['precio'].",'".$_POST['estado']."');";

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        header('Location: ../activos.php?msg=success');
    }
    else{
        $conn->close();
        header('Location: ../activos.php?msg=error');
    }
}

function eliminarActivo(){
    $conn=getConnection();
    $sql="call paAdministrarArticulo(4,".$_POST['id'].",null,null,null,null,null);";
    $dataResponse=[];
    if($conn->query($sql)===TRUE){
        $dataResponse=['msg'=>'true'];
    }
    else{$dataResponse=['msg'=>'false'];}
    $conn->close();

    header('Content-type: application/json; charset=utf-8');
    echo json_encode($dataResponse);
    exit();
}

function seleccionarActivos($identificador, $categoria){

    $conn = getConnection();
    $sql = "call paAdministrarArticulo(".$identificador.",null,null,".$categoria.",null,null,null);";
    $result = $conn->query($sql);
    $activos = [];
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

        $conn->close();
        if(isset($_POST['ajax'])){echo json_encode($activos);}
        else{return $activos;}
    }
    else {
        if(isset($_POST['ajax'])){echo json_encode($activos);}
        else{return $activos;}
    }

}

function test(){echo "paAdministrarArticulo(7,".$_POST['Id'].",null,null,null,null,null);";}

function selectPorCategoria2(){

    $conn = getConnection();
    $sql = "call paAdministrarArticulo(".$_POST['paTipo'].",null,null,".$_POST['subcategoria'].",null,null,null);";
    $result = $conn->query($sql);
    $activos = [];
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
        $json['msg'] = 'success';
    }else{
        $json['Type'] = 'selectPorCategoria';
        $json['Success'] = false;
        $json['Activos'] = $activos;
        $json['msg'] = 'error';
    }
    $conn->close();
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($json);
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
