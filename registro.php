<?php
session_start();
error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', 1);
$nombreArchivo = basename(path: __FILE__);
include "./caracteristicas/utilidades/header.php";
include "./caracteristicas/servidor/añadirUsuario.php";
include "./caracteristicas/validacion/validacionUsuario.php";

if($_SESSION['nombre_usuario']){
    header("Location: ./iniciado.php");
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if(nombreUsuarioValidacion($_POST['nombreUsuario'])){
        $_SESSION['nombreUsuario'] = $_POST['nombreUsuario'];
    } else{
        $_SESSION['nombreUsuario'] = null;
        $_SESSION['error'] = "{$_SESSION['error']}<h2>Nombre de usuario es invalido, por favor ingrese un nombre de usuario valido.</h2><br>";
    }

    if(emailValidacion( $_POST['email'] ) ){
        $_SESSION['email'] = $_POST['email'];
    } else{
        $_SESSION['email'] = null;
        $_SESSION['error'] = "{$_SESSION['error']}<h2>Email es invalido, por favor ingrese un email valido.</h2><br>";
    }

    if(contraseñaValidacion($_POST['contraseñaUno'],$_POST['contraseñaDos'])){
        $_SESSION['contraseñaUno'] = $_POST['contraseñaUno'];
        $_SESSION['contraseñaDos'] = $_POST['contraseñaDos'];
    } else{
        $_SESSION['contraseñaUno'] = null;
        $_SESSION['contraseñaDos'] = null;
        $_SESSION['error'] = "{$_SESSION['error']}<h2>Las contraseñas no coinciden porfavor ingreselas de nuevo.</h2><br>";
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<div>
    <form accept="utf-8" method="POST">
        <h2>Registro</h2>
        <br>
        <!-- Nombre de usuario -->
        <label for="nombreUsuario">Nombre usuario</label>
        <br>
        <input
            placeholder="Ingrese el nombre del usuario" 
            type="text"
            name="nombreUsuario"
            id="nombreUsuario"
            value="<?php echo $_SESSION['nombreUsuario'] ?? ''; ?>"
            required
            minlength="3"
            maxlength="35"
            pattern="[A-Za-z0-9_.]{3,35}"
            title="Solo se admiten letras, números, guiones bajos y puntos (mínimo 3 caracteres, máximo 35)"
        >
        <br><br>
         <!-- Email -->
        <label for="email">Email</label>
        <br>
        <input
            type="email"
            name="email"
            id="email"
            value="<?php echo $_SESSION['email'] ?? ''; ?>"
            required
            minlength="3"
            maxlength="40"
            title="Introduce un correo electrónico válido">
        <br><br>
        <!-- Contraseña -->
        <label for="contraseñaUno">Contraseña</label>
        <br>
        <input
            type="password"
            name="contraseñaUno"
            id="contraseñaUno"
            value="<?php echo $_SESSION['contraseñaUno'] ?? ''; ?>"
            required
            minlength="8"
            maxlength="20"
            pattern="[A-Za-z0-9]{8,20}"
            title="Debe tener al menos 8 caracteres, incluyendo una letra y un número">
        <br><br>
        <!-- Confirmar contraseña -->
        <label for="contraseñaDos">Repite la contraseña</label>
        <br>
        <input
            type="password"
            name="contraseñaDos"
            id="contraseñaDos"
            value="<?php echo $_SESSION['contraseñaDos'] ?? ''; ?>"
            required
            minlength="8"
            maxlength="20"
            pattern="[A-Za-z0-9]{8,20}"
            title="Debe coincidir con la contraseña anterior">
        <br><br>
        <!-- Botón de envío -->
        <button type="submit">Enviar</button>
    </form>    
</div>

<?php
if($_SESSION['nombreUsuario'] && $_SESSION['email'] && $_SESSION['contraseñaUno'] && $_SESSION['contraseñaDos']){
    $_SESSION['error'] = null;
    añadirUsuario($_SESSION['nombreUsuario'],$_SESSION['email'], $_SESSION['contraseñaUno']);
    $_SESSION['nombreUsuario'] = null;
    $_SESSION['email'] = null;
    $_SESSION['contraseñaUno'] = null;
    $_SESSION['contraseñaDos'] = null;
    header(header: "Location: ./inicio_sesion.php");
} else{
    echo $_SESSION['error'];
    $_SESSION['error'] = null;
}
include "./caracteristicas/utilidades/footer.php";