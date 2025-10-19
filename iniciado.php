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
    // El usuario sale de su cuenta, limpieza de cookies.
    
   // if (!empty($_COOKIE[REMEMBER_COOKIE_NAME])) {

        /*
        try {
            $pdo = db_connect();
            // revokeToken ya borra la cookie cliente (clearRememberCookie) en tu implementación
            revokeToken($pdo, $_COOKIE[REMEMBER_COOKIE_NAME]);
        } catch (Exception $e) {
            // Si falla la BD, al menos intentamos limpiar cookie cliente
            error_log("Error al revocar token remember: " . $e->getMessage());
            clearRememberCookie();
        }
    } else {
        // asegurar limpieza aunque no exista entrada en BD
        clearRememberCookie();
    }
    $_SESSION['nombre_usuario'] = null;
    $_SESSION['email_usuario'] = null;
*/
    /*
    $_SESSION = [];

    // Borrar cookie de sesión si se usa cookie de sesión
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', [
            'expires' => time() - 42000,
            'path' => $params['path'],
            'domain' => $params['domain'] ?? '',
            'secure' => $params['secure'] ?? false,
            'httponly' => $params['httponly'] ?? true,
            'samesite' => $params['samesite'] ?? 'Lax'
        ]);
    }
*/
    // Destruir la sesión
    //session_destroy();

    //header("Location: ./inicio_sesion.php");
}

include "./caracteristicas/utilidades/footer.php"?>