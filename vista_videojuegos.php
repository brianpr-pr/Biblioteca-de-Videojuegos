<?php
session_start();
error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', 1);
$nombreArchivo = basename(path: __FILE__);
require "./caracteristicas/utilidades/header.php";
require "./caracteristicas/servidor/administrarVideojuegos.php";
$_SESSION['nombre_usuario'] = "luigi";
?>

<h2>Colección de videojuegos</h2>
<table>
    <tr>
        <th>Caratula</th>
        <th>Título</th>
        <th>Fecha de lanzamiento</th>
    </tr>
    <?php echo mostrarVideojuegos();?>
</table>

<?
include "./caracteristicas/utilidades/footer.php";