<?php
session_start();
error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', 1);
$nombreArchivo = basename(path: __FILE__);
require "./caracteristicas/utilidades/header.php";
require "./caracteristicas/servidor/administrarVideojuegos.php";
include_once "./caracteristicas/usuario/usuario.php";

if($_GET['salir']){
    salirUsuario();
}

if(!$_SESSION['nombre_usuario']){
    header("Location: ./inicio_sesion.php?error=Es necesario que inicie sesión antes de poder ver la colección de videojuegos");
}
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
<br><br>
<div style="margin-left: 15px;">
    <?php if ($_SESSION['nombre_usuario']): ?>
    <form method="GET">
        <label for="salir">Pulse en el boton para salir de su cuenta.</label>
        <br>
        <button name="salir" id="salir" value="true" type="send">Salir de la cuenta</button>
    </form>
    <?php endif; ?>
</div>
<?
include "./caracteristicas/utilidades/footer.php";