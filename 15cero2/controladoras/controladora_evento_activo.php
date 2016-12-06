 <?php 
require_once ("database.php");

        if (isset($_POST['consulta'])) {
            switch($_POST['consulta']) {

            case 'agregarActivosEvento': //listo
                agregarActivosEvento();
                break;
            case 'eliminarActivoEvento': //listo
                eliminarActivoEvento();
                break;
            case 'seleccionarActivosEventos': //listo
                seleccionarActivosEventos();
                break;
            case 'cantidadActivos': //listo
                cantidadActivos();
                break;   
                             
            }
        }

function agregarActivosEvento(){
        $conn = getConnection();
        $sql = "call paAdministrarEven_Art(2,'".$_POST['activo']."',".$_POST['evento'].",".$_POST['cantidad'].");";
        if ($conn->query($sql) === TRUE) {
            //header("Location: ../insertar_activo_evento.php?e=".$_POST["evento"]);
            $jsondata['Type'] = 'activoEvento';
            $jsondata['Success'] = true;
            $jsondata['Cantidad'] = $_POST['cantidad'];
        }else{
            $jsondata['Type'] = 'activoEvento';
            $jsondata['Success'] = false;
        }
        $conn->close();
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($jsondata);
        exit();
}

function eliminarActivoEvento(){
    $conn = getConnection();
        $sql = "call paAdministrarEven_Art(4,'".$_POST['activo']."',".$_POST['evento'].",null);";
        if ($conn->query($sql) === TRUE) {     
            $json['Type'] = "eliminarActivoEvento";
            $json['Success'] = true;  
            $json['Activo'] = $_POST['activo'];         
        } else {
            $json['Type'] = "eliminarActivoEvento";
            $json['success'] = false;        
        }
        $conn->close();
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($json);
        exit();
}

function seleccionarActivosEventos(){
        $conn = getConnection();
        $sql = "call paAdministrarEven_Art(1,null,".$_POST['id'].",null);";
        $result = $conn->query($sql);
        $activos = null;
        $cont = 0;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $activos[$cont][0] = $row['Descripcion'];
                $activos[$cont][1] = $row['Cantidad'];
                $cont ++;
            }

            $json['Activos'] = $activos;
            $json['Success'] = true;
        } else {
            $json['Success'] = false;
        }
        $json['Evento'] = $_POST['id'];
        $json['Type'] = 'seleccionarActivosEventos';
        $conn->close();
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($json);
        exit();
    }

    function seleccionarActivosEventosArray($id){
        $conn = getConnection();
        $sql = "call paAdministrarEven_Art(1,null,".$id.",null);";
        $result = $conn->query($sql);
        $activos = null;
        $cont = 0;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $activos[$cont][0] = $row['Descripcion'];
                $activos[$cont][1] = $row['Cantidad'];
                $activos[$cont][2] = $row['Codigo'];
                $cont ++;
            }
        }
        return $activos;
        exit();
    }
    function cantidadActivos(){
        $conn = getConnection();
        $sql = "select disponibles from tbbodega where codigo = '".$_POST['codigo']."'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $json['cantidad'] = $row['disponibles'];
            }
            $json['Success'] = true;

        }
        //$json['cantidad'] =$_POST['codigo'];
        $json['Type'] = 'cantidadActivos';
        $conn->close();
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($json);
        exit();
       /* $json['cantidad'] = 7;
        $json['Success'] = true;
        $json['Type'] = 'cantidadActivos';
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($json);*/
    }

    function seleccionarActivosEventosInforme($id){
        $conn = getConnection();
        $sql = "call paAdministrarEven_Art(5,null,".$id.",null);";
        $result = $conn->query($sql);
        $activos = null;
        $cont = 0;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $activos[$cont][0] = $row['precio'];
                $activos[$cont][1] = $row['codigo'];
                $activos[$cont][2] = $row['descripcion'];
                $activos[$cont][3] = $row['cantidad'];
                $cont ++;
            }
        }
        return $activos;
        exit();
    }

?>