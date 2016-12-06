<?php

require_once 'database.php';

    //echo "consultas";
    if (isset($_POST['consulta'])) {
        switch($_POST['consulta']) {
        case 'login':
            validarLogueo();
            break;
        }
    }

function validarLogueo(){
        session_start();
        $conn = getConnection();
        $sql = "call paVerificarLogin('".$_POST['user']."','".$_POST['pass']."');";
        $result = $conn->query($sql);
        $jsondata = [];

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if(($_POST['user'] === $row['Usuario'])&& ($_POST['pass']===$row['Contrasena'])){
                    $jsondata['success'] = true;
                    $_SESSION['logged']=true;
                    $_SESSION['user'] = $_POST['user'];
                }
                else{
                    $jsondata['success'] = false;
                }
            }
        }
        else {
            $jsondata['success'] = false;
        }
        $conn->close();
        //Aunque el content-type no sea un problema en la mayoría de casos, es recomendable especificarlo
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($jsondata);
        exit();
    }

/*
function validarLogueo(){

    $conn = getConnection();
    $sql = "call paVerificarLogin('".$_POST['user']."','".$_POST['pass']."');";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            if(($_POST['user'] === $row['Usuario'])&& ($_POST['pass']===$row['Contrasena'])){
            //	echo "datos correctos";

            //	header('Location: InsertarActivo.php');
                header('Location: ../home.php');
            }else{
                echo "Usuario o contraseña incorrectos";
            }
        }
    } else {
    	echo "Usuario o contraseña incorrectos";
    }
    $conn->close();
    //Aunque el content-type no sea un problema en la mayoría de casos, es recomendable especificarlo
    //header('Content-type: application/json; charset=utf-8');
    //echo json_encode($jsondata);
    exit();
}*/
 ?>
