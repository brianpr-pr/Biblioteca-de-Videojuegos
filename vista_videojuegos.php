<?php
session_start();
error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', 1);
$nombreArchivo = basename(path: __FILE__);
include "./caracteristicas/utilidades/header.php";
include "./caracteristicas/servidor/mostrarVideojuegos.php/";
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