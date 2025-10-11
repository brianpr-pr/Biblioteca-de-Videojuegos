<?php
session_start();
error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', 1);
$nombreArchivo = basename(path: __FILE__);
include "./caracteristicas/utilidades/header.php";
include "./caracteristicas/validacion/validacion.php";
$errorMensaje = "";
$validForm = true;

if($_SESSION['nombre_usuario']){
    header("Location: ./iniciado.php");
}

if(!inicioSesion( $_POST['email'], $_POST['contraseña'] ) ){
    $_SESSION['email'] = null;
    $_SESSION['nombre_usuario'] = null;
    $validForm = false;
    $errorMensaje = "{$errorMensaje}<h2>Email no es correcto.</h2><br>";
}
?>

<div>
    <form accept="utf-8" method="POST">
        <h2>Inicio de sesión</h2>
        <br>
        <!-- Email -->
        <label for="email">Email</label>
        <br>
        <input
            type="email"
            name="email"
            id="email"
            required
            maxlength="40"
            title="Introduce un correo electrónico válido">
        <br><br>
        <!-- Contraseña -->
        <label for="contraseña">Contraseña</label>
        <br>
        <input
            type="password"
            name="contraseña"
            id="contraseña"
            required
            minlength="8"
            maxlength="20"
            pattern="(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}"
            title="Debe tener al menos 8 caracteres, incluyendo una letra y un número">
        <br><br>
        <!-- Botón de envío -->
        <button value="true" name="enviarInicio" type="submit">Enviar</button>
    </form>    
</div>

<?php
if($validForm){
    header("Location: ./iniciado.php");
}

if($_POST['enviarInicio']){
echo "<h2>{$errorMensaje}</h2>";
}

include "./caracteristicas/utilidades/footer.php";