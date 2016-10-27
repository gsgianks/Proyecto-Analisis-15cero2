<?php
		require_once ("database.php");

	    if (isset($_POST['consulta'])) {
	        switch($_POST['consulta']) {

            case 'agregarCliente': //listo
                agregarCliente();
                break;
            case 'modificarCliente': //listo
                modificarCliente();
                break;
            case 'eliminarCliente': //listo
                eliminarCliente();
                break;
	        }
		} 


	function agregarCliente(){

        $conn = getConnection();
        $sql = "call paAdministrarCliente(2,null,'".$_POST['nombre']."','".$_POST['correo']."','".$_POST['telefono']."','".$_POST['direccion']."');";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();   
            if($_POST['donde'] == 'clientes'){
                $jsondata['Type'] = "clienteForm";    
            }else{
                $jsondata['Type'] = "cliente";
            }                 
            $jsondata['Success'] = true;            
            $jsondata['Id'] = $row['Id'];
            $jsondata['Name'] = $_POST['nombre'];
            $jsondata['Correo'] = $_POST['correo'];
            $jsondata['Telefono'] = $_POST['telefono'];
            $jsondata['Direccion'] = $_POST['direccion'];
        } else {
            if($_POST['donde'] == 'clientes'){
                $jsondata['Type'] = "clienteForm";    
            }else{
                $jsondata['Type'] = "cliente";
            } 
            $jsondata['success'] = false;        
        }
        $conn->close();
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($jsondata);
        exit();

    }

    function cargarClientes(){

     $conn = getConnection();
     $sql = "call paAdministrarCliente(1,null,null,null,null,null)";
        $result = $conn->query($sql);
        $array = null;
        $cont = 0;
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $array[$cont][0] = $row['Id'];
                $array[$cont][1] = $row['Nombre'];
                $array[$cont][2] = $row['Correo'];
				$array[$cont][3] = $row['Telefono'];
				$array[$cont][4] = $row['Direccion'];

                $cont++;
            }
        }
        $conn->close();
        return $array;
    }
    function modificarCliente(){
        $conn = getConnection();
        $sql = "call paAdministrarCliente(3,".$_POST['idCliente'].",'".$_POST['nombre']."','".$_POST['correo']."','".$_POST['telefono']."','".$_POST['direccion']."');";
        if ($conn->query($sql) === TRUE) {
            $jsond['Type'] = 'modificarCliente';
            $jsond['Success'] = true;     
            $jsond['IdCliente'] = $_POST['idCliente'];
            $jsond['Nombre'] = $_POST['nombre'];
            $jsond['Correo'] = $_POST['correo'];
            $jsond['Telefono'] = $_POST['telefono'];
            $jsond['Direccion'] = $_POST['direccion'];
        }
        else{
            $jsond['Type'] = 'modificarCliente';
            $jsond['Success'] = false;
        }
        $conn->close();
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($jsond);
        exit();
    }
    function eliminarCliente(){
        $conn = getConnection();
        $sql = "call paAdministrarCliente(4,".$_POST['idCliente'].",null,null,null,null);";
        if ($conn->query($sql) === TRUE) {
            $jsond['Type'] = 'eliminarCliente';
            $jsond['Success'] = true;     
            $jsond['Cliente'] = $_POST['idCliente'];
        }
        else{
            $jsond['Type'] = 'eliminarCliente';
            $jsond['Success'] = false;
        }
        $conn->close();
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($jsond);
        exit();
    }
 ?>
