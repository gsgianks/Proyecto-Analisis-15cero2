<!DOCTYPE html>
<html>
<head>
    <title>Insertar Evento</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/newStyle.css">
    <link href="css/prueba.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="js/css/alertify.min.css">
    <link rel="stylesheet" href="js/css/themes/default.min.css">

    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/agregarCliente.js"></script>
    <script type="text/javascript" src="js/formulario.js"></script>
    <script type="text/javascript" src="js/alertify.min.js"></script>
</head>
<body>

<?php
 require_once ("controladoras/controladora_evento.php");
 require_once ("controladoras/controladora_cliente.php");

 $array = cargarClientes();
 ?>

<?php include "_nav.php" ?>
  <div class="main_content">
 <aside>
    <section class="formulario">
    <h1>Insertar Evento</h1>

        <form action="controladoras/controladora_evento.php" method="post">
            <input type="hidden" name="consulta" value="agregarEvento">
            <label >Nombre Evento:</label><input type="text" name="nombreEven" required>
            <label >Cliente:</label><br>
            <select id="clientes" name="cliente">
                    <?php   for($i = 0;$i<count($array);$i++){?>
                        <option required value='<?php echo $array[$i][0]?>'><?php echo $array[$i][1]?></option>
                    <?php }?>
                    <option value="0">--Agregar Nuevo--</option>
            </select> <br />
            <label >Fecha Inicio:</label><input type="date" name="fechaIni" placeholder="yyyy-MM-dd" required>
            <label >Fecha Final:</label><input type="date" name="fechaFin" placeholder="yyyy-MM-dd"required>
            <label >Ubicación:</label><input type="text" name="ubicacion" required>

         <input class="submit" type="submit" value="Agregar">

        </form>
        </section>
        <section class="formulario" id="clienteNuevo" style="display:none;">
            <h1>Insertar Cliente</h1>
            <form action="controladoras/controladora_cliente.php" method="post">
                <input type="hidden" name="consulta" value="agregarCliente">
                <input type="hidden" name="donde" value="nada">
                <label>Nombre:</label><br><input type="text" name="nombre">
                <label>Correo:</label><br><input type="email" name="correo">
                <label>Direcci&oacute;n</label><br><input type="text" name="direccion">
                <label>Telefono</label><br><input type="text" name="telefono">
                <input class="submit" type="submit" value="Agregar">
            </form>
        </section>

  </aside>
    <section class="lista-eventos">
        <h3>Eventos</h3>
            <table id="table-eventos" border="2">
            <tr>
                <td>Nombre</td>
                <td>Fecha Inicio</td>
                <td>Fecha Final</td>
                <td>Lugar</td>
                <td>Nombre Cliente</td>
                <!--<td>Detalle</td>-->
                <td>Opciones</td>
            </tr>
            <?php require_once 'controladoras/controladora_evento.php'; $eventos = seleccionarEventos();
            for($i = 0;$i<count($eventos);$i++){?>
                <tr class="opciones">
                    <td style='display: none;'><?php echo $eventos[$i][0]; ?></td>
                    <td><?php echo $eventos[$i][1]; ?></td>
                    <td><?php echo $eventos[$i][2]; ?></td>
                    <td><?php echo $eventos[$i][3]; ?></td>
                    <td><?php echo $eventos[$i][4]; ?></td>
                    <td><?php echo $eventos[$i][6]; ?></td>
                    <!-- <td><button class="id02" onclick="mostrarDetalleEvento(<?php echo $eventos[$i][0] ?>)">Mostrar</button></td> -->
                    <td><ul class="menu-evento">
                            <li><p>Opciones</p>
                                <ul>
                                    <li><button onclick="mostrarDetalleEvento(<?php echo $eventos[$i][0]; ?>)">Ver</button></li>
                                    <li><button onclick="modificarEvento(<?php echo $eventos[$i][0]; ?>)">Modificar</button></li>
                                    <li><button onclick="eliminarEvento(<?php echo $eventos[$i][0]; ?>)">Eliminar</button></li>
                                </ul>
                            </li>
                        </ul>
                    </td>
                </tr>
            <?php }?>
    </section>
  </div>
  <div id="id02" class="modal">
          <!-- Modal Content -->
            <div class="modal-content animate">
                <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
                <div class="div-modal2">

                </div>
            </div>
        </div>
  </div>
  <div id="id03" class="modal">
          <!-- Modal Content -->
            <div class="modal-content animate">
                <span onclick="document.getElementById('id03').style.display='none'" class="close" title="Close Modal">&times;</span>
                <div class="div-modal3">
                    <section class="formulario">
                    <h1>Modificar Evento</h1>

                    <form action="controladoras/controladora_evento.php" method="post">
                        <input type="hidden" name="consulta" value="modificarEvento">
                        <input type="hidden" name="nombreCliente" value="modificarEvento">
                        <input type="hidden" name="idEvento">
                        <label >Nombre Evento:</label><input type="text" name="nombreEven" required>
                        <label >Cliente:</label><br>
                        <select id="clientesModal" name="cliente">
                                <?php   for($i = 0;$i<count($array);$i++){?>
                                    <option required value='<?php echo $array[$i][0]?>'><?php echo $array[$i][1]?></option>
                                <?php }?>
                                <option value="0">--Agregar Nuevo--</option>
                        </select> <br />
                        <label >Fecha Inicio:</label><input type="date" name="fechaIni" placeholder="yyyy-MM-dd" required>
                        <label >Fecha Final:</label><input type="date" name="fechaFin" placeholder="yyyy-MM-dd"required>
                        <label >Ubicación:</label><input type="text" name="ubicacion" required>

                     <input class="submit" type="submit" value="Modificar">

                    </form>
                    </section>
                    <section class="formulario" id="clienteNuevoModal" style="display:none;">
                        <h1>Insertar Cliente</h1>
                        <form action="controladoras/controladora_cliente.php" method="post">
                            <input type="hidden" name="consulta" value="agregarCliente">
                            <input type="hidden" name="donde" value="nada">
                            <label>Nombre:</label><br><input type="text" name="nombre">
                            <label>Correo:</label><br><input type="email" name="correo">
                            <label>Direcci&oacute;n</label><br><input type="text" name="direccion">
                            <label>Telefono</label><br><input type="text" name="telefono">
                            <input class="submit" type="submit" value="Agregar">
                        </form>
                    </section>
                </div>
            </div>
        </div>
  </div>
</body>
</html>
