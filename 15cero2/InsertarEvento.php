<!DOCTYPE html>
<html>
<head>
    <title>Insertar Evento</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/newStyle.css">
    <link rel="stylesheet" href="css/activos.css">
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
        <aside class="aside-left">
            <section class="aside-content">
                <h1>Insertar Evento</h1>

                <form class="formulario" action="controladoras/controladora_evento.php" method="post">
                    <input type="hidden" name="consulta" value="agregarEvento">
                    <div class="form-group">
                        <label>Nombre Evento:</label><input class="form-control" type="text" name="nombreEven" required>
                    </div>
                        <div class="form-group">
                        <label >Cliente:</label>
                            <select id="clientes" name="cliente" class="form-control">
                                <?php   for($i = 0;$i<count($array);$i++){?>
                                <option required value='<?php echo $array[$i][0]?>'><?php echo $array[$i][1]?></option>
                                <?php }?>
                                <option value="0">--Agregar Nuevo--</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label >Fecha Inicio:</label><input class="form-control" type="date" name="fechaIni" placeholder="yyyy-MM-dd" required>
                        </div>
                        <div class="form-group">
                            <label >Fecha Final:</label><input class="form-control" type="date" name="fechaFin" placeholder="yyyy-MM-dd"required>
                        </div>
                        <div class="form-group">
                            <label >Ubicaci&oacute;n:</label><input class="form-control" type="text" name="ubicacion" required>
                        </div>

                        <button class="submit btn btn-primary" type="submit" value="Agregar">Agregar</button>
                    </form>
                </section>

<!--                <section class="formulario" id="clienteNuevo" style="display:none;">
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
-->
            </aside>
            <section class="lista-eventos">
                <h3>Eventos</h3>
                <?php require_once 'controladoras/controladora_evento.php'; $eventos = seleccionarEventos();
                if($eventos != null){?>
                <table id="table-eventos">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Final</th>
                            <th>Lugar</th>
                            <th>Nombre Cliente</th>
                            <th></th>
                            <!--</th>Detalle</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php for($i = 0;$i<count($eventos);$i++){?>
                            <tr class="opciones">
                                <td style='display: none;'><?php echo $eventos[$i][0]; ?></td>
                                <td><?php echo $eventos[$i][1]; ?></td>
                                <td><?php echo $eventos[$i][2]; ?></td>
                                <td><?php echo $eventos[$i][3]; ?></td>
                                <td><?php echo $eventos[$i][4]; ?></td>
                                <td><?php echo $eventos[$i][6]; ?></td>
                                <!-- <td><button class="id02" onclick="mostrarDetalleEvento(<?php echo $eventos[$i][0] ?>)">Mostrar</button></td> -->
                                <td>
                                    <ul class="options">
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
                        </tbody>
                </table>
                <?php }else{ ?>

                    <p>No hay eventos registrados</p>

                <?php }?>
            </section>
                </div>

                <div id="id02" class="modal">
                    <!-- Modal Content -->
                    <div class="modal-content animate">
                        <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
                        <div class="div-modal2"></div>
                    </div>
                </div>

                <div id="id03" class="modal">
                    <!-- Modal Content -->
                    <div class="modal-content animate">
                        <span onclick="document.getElementById('id03').style.display='none'" class="close" title="Close Modal">&times;</span>
                        <div class="div-modal3">
                            <section class="formulario form-left">
                                <h1>Modificar Evento</h1>

                                <form action="controladoras/controladora_evento.php" method="post">

                                    <input type="hidden" name="consulta" value="modificarEvento">
                                    <input type="hidden" name="nombreCliente" value="modificarEvento">
                                    <input type="hidden" name="idEvento">
                                    <div class="form-group"><label >Nombre Evento:</label><input class="form-control" type="text" name="nombreEven" required></div>
                                    <div class="form-group"><label >Cliente:</label><br>
                                    <select class="form-control" id="clientesModal" name="cliente">
                                        <?php   for($i = 0;$i<count($array);$i++){?>
                                            <option required value='<?php echo $array[$i][0]?>'><?php echo $array[$i][1]?></option>
                                            <?php }?>
                                            <option value="0">--Agregar Nuevo--</option>
                                    </select><br></div>

                                    <div class="form-group"><label >Fecha Inicio:</label><input class="form-control" type="date" name="fechaIni" placeholder="yyyy-MM-dd" required></div>
                                    <div class="form-group"><label >Fecha Final:</label><input class="form-control" type="date" name="fechaFin" placeholder="yyyy-MM-dd" required></div>
                                    <div class="form-group"><label >Ubicaci&oacute;n:</label><input class="form-control" type="text" name="ubicacion" required></div>

                                    <button class="submit btn btn-primary" type="submit">Modificar</button> 
                                    </form>
                                </section>

                                <section class="formulario form-right" id="clienteNuevoModal" style="display:none;">
                                    <h1>Insertar Cliente</h1>
                                    <form action="controladoras/controladora_cliente.php" method="post">
                                        <input type="hidden" name="consulta" value="agregarCliente">
                                        <input type="hidden" name="donde" value="nada">
                                        <div class="form-group"><label>Nombre:</label><br><input class="form-control" type="text" name="nombre" required></div>
                                        <div class="form-group"><label>Correo:</label><br><input class="form-control" type="email" name="correo" required></div>
                                        <div class="form-group"><label>Direcci&oacute;n</label><br><input class="form-control" type="text" name="direccion" required></div>
                                        <div class="form-group"><label>Telefono</label><br><input class="form-control" type="text" name="telefono" required></div>
                                        <button class="submit btn btn-primary" type="submit">Agregar</button> 
                                    </form>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="id04" class="modal">
                    <!-- Modal Content -->
                    <div class="modal-content animate">
                        <span onclick="document.getElementById('id04').style.display='none'" class="close" title="Close Modal">&times;</span>
                        <div class="div-modal4">
                                <h3>Insertar Cliente</h3>
                                <hr>
                                <form class="formulario" action="controladoras/controladora_cliente.php" method="post">
                                    <input type="hidden" name="consulta" value="agregarCliente">
                                    <input type="hidden" name="donde" value="nada">
                                    <div class="form-group">
                                    <label>Nombre:</label><br><input class="form-control" type="text" name="nombre" required>
                                    </div>
                                    <div class="form-group">
                                    <label>Correo:</label><br><input class="form-control" type="email" name="correo" required>
                                    </div>
                                    <div class="form-group">
                                    <label>Direcci&oacute;n</label><br><input class="form-control" type="text" name="direccion" required>
                                    </div>
                                    <div class="form-group">
                                    <label>Telefono</label><br><input class="form-control" type="text" name="telefono" required>
                                    </div>
                                    <button class="submit btn btn-primary" type="submit">Agregar</button> 
                                </form>                  
                        </div>
                    </div>
                </div>
            </body>
            </html>
