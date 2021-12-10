<?php
    require_once __DIR__."/clases/procesos.php";
    if(isset($_POST["login"])) {
        $user = $_POST["username"];
        $pw = $_POST["password"];

        $db = new Procesos();

        $resultLogin = $db->seleccionar("SELECT * FROM usuarios WHERE nombre='$user' AND pw='$pw' LIMIT 1");

        $filaLogin = $db->selectArray($resultLogin,MYSQLI_ASSOC);

        if($db->num_Filas($resultLogin) > 0) {
            session_start();
            $_SESSION["id"] = $filaLogin["idUsuario"];
            $_SESSION["tipoPerfil"] = $filaLogin["tipoPerfil"];

            header("Location: index.php");
        } else {
            echo 'Usuario o contraseña incorrectos';
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inicio de sesión</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <link rel="stylesheet" href="css/estilo.css">
    </head>
    <body>
        <div id="cajaRegister">
            <p><span>Flash</span>Cards</p>
            <div id="cajaRegister">
                <form action="#" method="post">
                    <h2>Creación de cuenta</h2>
                    <label for="username"><i class="fas fa-user"></i></label>
                    <input type="text" name="username" id="username" placeholder="Nombre" required>
                    <label for="username"><i class="fas fa-user"></i></label>
                    <input type="text" name="username" id="username" placeholder="Apellido" required>

                    <label for="username"><i class="fas fa-envelope"></i></label>
                    <input type="text" name="email" id="email" placeholder="Correo" required>

                    <label for="password"><i class="fas fa-lock"></i></label>
                    <input type="password" name="password" id="password" placeholder="Contraseña" required>
                    <input type="submit" value="Crear cuenta" name="crear[]">
                </form>
            </div>
        </div>
    </body>
</html>