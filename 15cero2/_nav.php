
<nav class="top-vav">
    <div class="nav-content">
        <a class="left" href="index.php">15 C E R O 2</a>
        <a href="InsertarEvento.php">Eventos</a>
        <a href="insertar_cliente.php">Clientes</a>
        <a href="activos.php">Activos</a>
        <a href="bodega.php">Bodega</a>
    </div>

    <?php if(isset($_GET['msg'])){
            if($_GET['msg']==='success'){ echo '<span class="nav-alerts" type="success" style="color:green;width:100%;margin:auto;display:block;text-align:center;height:0;overflow-y:hidden">La operación se realizó con éxito</span>';}
            elseif($_GET['msg']==='error'){echo '<span class="nav-alerts" type="error" style="color:red;width:100%;margin:auto;display:block;text-align:center;height:0;overflow-y:hidden">Ocurrió un error en la operación</span>';}
        }
    ?>
</nav>
