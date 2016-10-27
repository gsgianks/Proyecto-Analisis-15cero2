
<nav class="top-vav">
    <ul class="nav-content">
        <li class="nav-item"><a href="home.php">Inicio</a></li>
        <li class="nav-item"><a href="activos.php">Activos</a></li>
        <li class="nav-item"><a href="bodega.php">Bodega</a></li>
        <li class="nav-item"><a href="InsertarEvento.php">Eventos</a></li>
        <li class="nav-item"><a href="insertar_cliente.php">Clientes</a></li>
    </ul>
    <?php if(isset($_GET['msg'])){
            if($_GET['msg']==='success'){ echo '<span class="nav-alerts" type="success" style="color:green;width:100%;margin:auto;display:block;text-align:center;height:0;overflow-y:hidden">La operación se realizó con éxito</span>';}
            elseif($_GET['msg']==='error'){echo '<span class="nav-alerts" type="error" style="color:red;width:100%;margin:auto;display:block;text-align:center;height:0;overflow-y:hidden">Ocurrió un error en la operación</span>';}
        }
    ?>
</nav>
