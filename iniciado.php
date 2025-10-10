<?php
session_start();
error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', 1);
$nombreArchivo = basename(path: __FILE__);
include "./caracteristicas/utilidades/header.php";

if($_SESSION['nombre_usuario']){
    $nombreUsuario = $_SESSION['nombre_usuario'];
}
?>

<h2>Bienvenido <?php echo $nombreUsuario;?></h2>
<form method="GET">
    <label for="salir">Pulse en el boton para salir de su cuenta.</label>
    <br>
    <button name="salir" value="true" type="send">Salir de la cuenta</button>
</form>


<?php 

if($_GET['salir']){
    $_SESSION['nombre_usuario'] = null;
    $_SESSION['email_usuario'] = null;
    header("Location: ./inicio_sesion.php");
}

include "./caracteristicas/utilidades/footer.php"?>