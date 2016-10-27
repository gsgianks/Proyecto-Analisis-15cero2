<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">

        <link rel="stylesheet" href="css/global.css">
        <link rel="stylesheet" href="css/index.css">

        <script type="text/javascript" src="./js/jquery.min.js"></script>
        <script type="text/javascript" src="./js/login.js"></script>

        <title>15cero2 Iniciar sesión</title>
    </head>
    <body>
        <div class="container main">
            <section>
                <header class="title">15 C E R O 2</header>
                <section class="login-section">
                    <form class="login-form">
                        <input id="tipo" type="hidden" name="consulta" value="login">
                        <h4 class="form-title">Iniciar sesión<hr></h4>
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

            </section>

            <footer>

            </footer>

        </div>

    </body>

</html>
