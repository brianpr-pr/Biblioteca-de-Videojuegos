<?php
session_start();
error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', 1);
$titulo = $_GET["titulo"];


if($titulo){
    include "./../servidor/administrarVideojuegos.php";
    include "./../servidor/datos_servidor.php";
    $resultado = '
    <tr>
        <th>Caratula</th>
        <th>Título</th>
        <th>Fecha de lanzamiento</th>
    </tr>';
    $resultado = $resultado . mostrarVideojuegosBuscador($titulo);
    echo $resultado;
}