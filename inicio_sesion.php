<?php
session_start();
error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', 1);
$nombreArchivo = basename(path: __FILE__);
include "./caracteristicas/utilidades/header.php";
include "./caracteristicas/validacion/validacionUsuario.php";
include "caracteristicas/cookies/manejo_tokens.php";

if (empty($_SESSION['nombre_usuario'])) {
    // intenta validar la cookie y obtener el username
    $pdo = db_connect();
    $username = validateRememberCookie($pdo); // devuelve username o null

    if ($username) {
        $_SESSION['nombre_usuario'] = $username;
    }
}

if($_SESSION['nombre_usuario']){
    header("Location: ./iniciado.php");
}

//Comprobación de que usuario que no ha iniciado sesión no tenga un token valido asignado,
//en cuyo caso lo inciamos automaticamente y redireccionamiento.



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
    //Al comentar esta línea lo que ocurre es que la refrescar la pagina me pregunta si quiero reenviar el formulario.
    //header("Location:" . $_SERVER['PHP_SELF']);
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
    try{
        echo "Creación de cookie iniciada.";
        $pdo =  db_connect();
        $token = createRememberToken($pdo, $_SESSION['nombre_usuario'], 7);
        setRememberCookie($token);
    } catch(Exception $e){
         echo "Error: $e";
    }
}

include "./caracteristicas/utilidades/footer.php";