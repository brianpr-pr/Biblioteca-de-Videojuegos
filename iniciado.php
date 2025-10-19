<?php
session_start();
error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', 1);
$nombreArchivo = basename(path: __FILE__);
include "./caracteristicas/utilidades/header.php";
include "./caracteristicas/cookies/manejo_tokens.php";

if (empty($_SESSION['nombre_usuario'])) {
    // intenta validar la cookie y obtener el username
    $pdo = db_connect();
    $username = validateRememberCookie($pdo); // devuelve username o null

    if ($username) {
        $_SESSION['nombre_usuario'] = $username;
    }
}

if(!$_SESSION['nombre_usuario']){
    header("Location: inicio_sesion.php");
    exit;
}
?>

<h2>Bienvenido <?php echo $_SESSION['nombre_usuario'];?></h2>
<div style="margin-left: 15px;">
    <?php if ($_SESSION['nombre_usuario']): ?>
    <form method="POST">
        <label for="salir">Pulse en el boton para salir de su cuenta.</label>
        <br>
        <button name="salir" id="salir" value="true" type="submit">Salir de la cuenta</button>
    </form>
    <?php endif; ?>
</div>

<a href="./editar_usuario.php">Editar datos del perfil</a>
<?php 

if($_POST['salir']){
    cerrarSesion();
}

include "./caracteristicas/utilidades/footer.php"?>