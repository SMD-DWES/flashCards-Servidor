<?php

function html() {

}

function head($titulo,$css=null) {
    echo "
    <head>
        <meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>$titulo</title>
    </head>
    ";
}

function nav() {
    echo "
        <nav>
            
        </nav>
    ";
}

function main($tipo=null) {

    echo "
        <body>
            <main>
    ";

    switch ($tipo) {
        case 'puntuacion':
            //Botón desloguearse
            echo "<a href='logout.php'>Desloguearse</a>";
            echo "
                <form action='#' method='post'>
                    <input type='number' name='iPuntos'>
                    <input type='submit' value='Enviar' name='enviar[]'>
                </form>
            ";
            firstLogin();
            break;
        
        default:
            echo 'POR DEFECTO';
            break;
    }



    echo "
        </main>
    </body>";
}