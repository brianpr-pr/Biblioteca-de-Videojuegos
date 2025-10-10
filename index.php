<?php
session_start();
error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', 1);
$nombreArchivo = basename(path: __FILE__);
include "./caracteristicas/utilidades/header.php";
include_once "./caracteristicas/usuario/usuario.php";

if($_GET['salir']){
    salirUsuario();
}
?>

<div>
    <h1>Bienvenido a la biblioteca de videojuegos <?php echo $_SESSION['nombre_usuario'] ?? 'Usuario';?></h1>
    <h2>El mejor sitio para almacenar videojuegos</h2>
</div>
<div>
    <?php if ($_SESSION['nombre_usuario']): ?>
    <form method="GET">
        <label for="salir">Pulse en el boton para salir de su cuenta.</label>
        <br>
        <button name="salir" value="true" type="send">Salir de la cuenta</button>
    </form>
    <?php endif; ?>
</div>

<?php
include "./caracteristicas/utilidades/footer.php"?>