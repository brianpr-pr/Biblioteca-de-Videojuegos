<?php
session_start();
error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', 1);
$nombreArchivo = basename(path: __FILE__);
include "./utilidades/header.php";

if($_GET['salir']){
    $_SESSION['nombre_usuario'] = null;
    $_SESSION['email_usuario'] = null;
    header("");
}

$salirSesion = '';

if($_SESSION['nombre_usuario']){
 $salirSesion = '<form method="GET">
    <label for="salir">Pulse en el boton para salir de su cuenta.</label>
    <br>
    <button name="salir" value="true" type="send">Salir de la cuenta</button>
</form>';
}
?>

<div>
    <h1>Bienvenido a la biblioteca de videojuegos <?php echo $_SESSION['nombre_usuario'] ?? 'Usuario';?></h1>
    <h2>El mejor sitio para almacenar videojuegos</h2>
</div>
<div>
    <?php echo $salirSesion;?>
</div>

<?php
include "./utilidades/footer.php"?>