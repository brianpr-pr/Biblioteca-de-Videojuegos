
<?php
session_start();
error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', 1);
include "./../servidor/datos_servidor.php";
include "./../servidor/administrarVideojuegos.php";
include "./../servidor/gestion_votos.php";

$voto = $_GET['voto'];
$tituloClave = $_GET['titulo_clave'];

if($voto !== 'like' && $voto !== 'dislike'){
    echo "<span style='color:red;'>Error en la votación.<br>Voto no valido.";
    exit;
}

if($voto === '' && $tituloClave === ''){
    echo "<span style='color:red;'>Error en la votación.<br>Voto no valido o usuario sin registrar.";
    exit;
}
if(!videojuegoDatos($tituloClave)){
    echo "<span style='color:red;'>Error en la votación.<br>El videojuego no existe.</span>";
    exit;
}


if(!usuarioPuedeVotar($_SESSION['nombre_usuario'], $tituloClave)){
    echo "<span style='color:red;'>Error en la votación.<br>Usted ya ha votado.</span>";
    exit;
}

if(!añadirVoto($_SESSION['nombre_usuario'], $tituloClave, $voto)){
    echo "<span style='color:red;'>Error en la votación.<br>No se ha podido añadir el voto a la base de datos.</span>";
    exit;
}



if($voto === 'like'){
    echo "<span style='color:green;'>Like enviado correctamente.</span>";
} elseif($voto === 'dislike'){
    echo "<span style='color:green;'>Dislike enviado correctamente.</span>";
} else{
    echo "<span style='color:red;'>Error en la votación.</span>";
}