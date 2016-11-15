<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>15 C E R O 2</title>

        <!-- Styles & fonts -->
        <link rel="stylesheet" href="css/global.css">
        <link rel="stylesheet" href="css/index.css">

        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                height: 100vh;
                margin: 0;
            }

            .flex-center {
                margin: 5em;
                align-items: center;
                justify-content: center;
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-family: 'Lato', sans-serif;
                font-weight: 100;
                font-size: 84px;
                margin-bottom: .5em
            }

            .links {display: flex;justify-content: center;overflow: hidden;transition: .5s;width: 50%;margin: auto}
            .links > a {
                margin: auto;
                color:darkorange;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="title m-b-md">
                    15 C E R O 2
                </div>

                <?php
                session_start();
                if(!isset($_SESSION['logged'])){$_SESSION['logged']=false;}
                if($_SESSION['logged']==false){
                ?>
                <section class="login-section">
                    <form class="login-form">
                        <input id="tipo" type="hidden" name="consulta" value="login">
                        <h4 class="form-title">
                            Iniciar sesión
                            <hr>
                        </h4>
                        <div class="form-group">
                            <label for="user">Usuario:</label><input class="form-control" type="text" name="user" id="user" required placeholder="Nombre de usuario">
                        </div>
                        <div class="form-group">
                            <label for="passwd">Contraseña: </label><input class="form-control" type="password" name="pass" id="passwd" required placeholder="Contraseña">
                        </div>
                        <span id="mensaje" style="color:red; font-size: 15px;"></span>
                        <button class="btn btn-primary" type="submit" name="button"><b>ENTRAR</b></button>
                    </form>
                </section>
                <?php } ?>
                <div class="links" style="height: <?php echo ($_SESSION['logged']==false)?'0':'2.5em'; ?>">
                    <a href="InsertarEvento.php">Eventos</a>
                    <a href="insertar_cliente.php">Clientes</a>
                    <a href="activos.php">Activos</a>
                    <a href="bodega.php">Bodega</a>
                </div>

            </div>
        </div>

        <script type="text/javascript" src="./js/jquery.min.js"></script>
        <script type="text/javascript" src="./js/login.js"></script>
    </body>
</html>
