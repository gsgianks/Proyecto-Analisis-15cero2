<?php
	require_once ("database.php");

    if (isset($_POST['consulta'])) {
            switch($_POST['consulta']) {

            case 'agregarCategoria':
                agregarCategoria();
                break;
			case 'cargarSubcategorias':
	            cargarSubcategorias($_POST['id']);
	            break;
			case 'eliminarCategoria':
				eliminarCategoria();
				break;
			case 'cargarCategoria_y_Subcategoria':
				cargarCategoria_y_Subcategoria();
				break;
           }
    }

	function cargarSubcategorias($id){

		$conn = getConnection();
        $sql = "select * from tbcategoria where IdCategoria=".$id.";";
        $result = $conn->query($sql);
        $array = [];
        $cont = 0;

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $array[$cont][0] = $row['Id'];
                $array[$cont][1] = $row['Nombre'];
                $array[$cont][2] = $row['IdCategoria'];
                $cont++;
            }
        }

        $conn->close();

        header('Content-type: application/json; charset=utf-8');
        echo json_encode($array);
		exit();

	}

	function agregarCategoria(){

        $conn = getConnection();
        $sql = "call paAdministrarCategoria(2,null,'".$_POST['nombre']."',".$_POST['categoria'].");";
        if ($conn->query($sql) === TRUE) {
	        $conn->close();
            header("Location: ../activos.php?msg=success");
        }
		else {
			$conn->close();
			header("Location: ../activos.php?msg=error");
		}
    }

	function cargarCategorias(){

		$conn = getConnection();
		$sql = "call paAdministrarCategoria(5,null,null,null)";
		$result = $conn->query($sql);
		$array = null;
		$cont = 0;

		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				$array[$cont][0] = $row['Id'];
				$array[$cont][1] = $row['Nombre'];
				$array[$cont][2] = $row['IdCategoria'];
				$cont++;
			}
		}
		//else {echo "No dio resultado";}

		$conn->close();
		return $array;
	}

    function cargarCategorias2(){

    	$conn = getConnection();
        $sql = "call paAdministrarCategoria(1,null,null,null)";
        $result = $conn->query($sql);
        $array = null;
        $cont = 0;

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $array[$cont][0] = $row['Id'];
                $array[$cont][1] = $row['Nombre'];
                $array[$cont][2] = $row['IdCategoria'];
                $cont++;
            }
        }
		//else {echo "No dio resultado";}

        $conn->close();
        return $array;
    }

	function cargarCategoriasRecursivo(){

    	$conn = getConnection();
        $sql = "call paAdministrarCategoria(5,null,null,null)";
        $result = $conn->query($sql);
        $array = null;
		$cont=0;

        if ($result->num_rows > 0) {
            // output data of each row

			while($row = $result->fetch_assoc()) {
                $array[$cont][0] = $row['Id'];
                $array[$cont][1] = $row['Nombre'];
                $array[$cont][2] = $row['IdCategoria'];
				$array[$cont][3]=[];
				$cont++;
            }

			$conn->close();
		}
		//else {echo "No dio resultado";}

		for($i=0; $i<count($array);$i++){
				$conn = getConnection();
				$sql = "select * from tbcategoria where IdCategoria=".$array[$i][0].";";
				$result = $conn->query($sql);
				$sub=[];

				if ($result->num_rows > 0) {
					// output data of each row
					$cont=0;
					while($row = $result->fetch_assoc()) {
						$sub[$cont][0]=$row['Id'];
						$sub[$cont][1]=$row['Nombre'];
						$sub[$cont][2]=$row['IdCategoria'];
						$array[$i][3]=$sub;
						$cont++;
					}

					$conn->close();
				}
				//else {echo "No dio resultado";}
		}
		return $array;

    }

	function eliminarCategoria(){

		$conn = getConnection();
		$sql = "call paAdministrarCategoria(4,".$_POST['IdCat'].",null,null);";
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

	function cargarCategoria_y_Subcategoria(){
		$conn = getConnection();
        $sql = "call paAdministrarArticulo(7,".$_POST['Id'].",null,null,null,null,null);";
        $result = $conn->query($sql);

        $row = $result->fetch_assoc();
	    $conn->close();
	    header('Content-type: application/json; charset=utf-8');
        echo json_encode(['data'=>$row]);
		exit();
	}
 ?>
