<?php
    session_start();

    $_SESSION = null; //La defino como null

    session_destroy(); //Destruye la sesión actual

    header("Location: login.php"); //Redirect
?>