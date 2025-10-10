<?php
// editar_videojuego.php
session_start();
error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', 1);
$nombreArchivo = basename(path: __FILE__);
include "./caracteristicas/utilidades/header.php";
include "./caracteristicas/servidor/datos_servidor.php";
include "./caracteristicas/utilidades/footer.php";