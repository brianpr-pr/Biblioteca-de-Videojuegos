<?php
session_start();
error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', 1);
include "./../servidor/datos_servidor.php";
include "./../servidor/gestion_votos.php";

$puntuacion =  $_GET['mostrar'];
$tituloClave = $_GET['titulo_clave'];
$tipoValor = '';
//echo $puntuacion . $tituloClave;

if($puntuacion !== 'contador_like' && $puntuacion !== 'contador_dislike'){
    echo false;
}

if($puntuacion === 'contador_like'){
    $tipoValor = 'like';
}

if($puntuacion === 'contador_dislike'){
    $tipoValor = 'dislike';
}

if($resultado = mostrarPuntuacion($tituloClave, $tipoValor)){
    echo $resultado;
}