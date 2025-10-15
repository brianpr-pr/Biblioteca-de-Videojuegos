<?php
session_start();
error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', 1);
$nombreArchivo = basename(path: __FILE__);
include "./caracteristicas/utilidades/header.php";
include "./caracteristicas/validacion/validacionUsuario.php";

if($_SESSION['nombre_usuario']){
    header("Location: ./iniciado.php");
}
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    if(array_key_exists('error', $_GET)){
        echo "<h1>{$_GET['error']}</h1>";
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if(!inicioSesion( $_POST['email'], $_POST['contraseña'] ) ){
        $_SESSION['email'] = null;
        $_SESSION['error'] = "{$_SESSION['error']}<h2>Email no es correcto.</h2><br>";
    }
    header("Location:" . $_SERVER['PHP_SELF']);
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
            placeholder="Ingrese su email." 
            type="email"
            name="email"
            id="email"
            required
            minlength="3"
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
            pattern="[A-Za-z0-9_.]+"
            title="Debe tener al menos 8 caracteres, incluyendo una letra y un número">
        <br><br>
        <!-- Botón de envío -->
        <button value="true" name="enviarInicio" type="submit">Enviar</button>
    </form>    
</div>

<?php
if( $_SESSION['email'] && $_SESSION['nombre_usuario']){
    $_SESSION['error'] = null;
    header("Location: ./iniciado.php");
}

include "./caracteristicas/utilidades/footer.php";