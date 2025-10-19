<?php
session_start();
error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', 1);
$nombreArchivo = basename(path: __FILE__);
include "./caracteristicas/utilidades/header.php";
require "./caracteristicas/servidor/administrarVideojuegos.php";
include "caracteristicas/cookies/manejo_tokens.php";


if (empty($_SESSION['nombre_usuario'])) {
    // intenta validar la cookie y obtener el username
    $pdo = db_connect();
    $username = validateRememberCookie($pdo); // devuelve username o null

    if ($username) {
        $_SESSION['nombre_usuario'] = $username;
    }
}

if(!($detallesVideojuego = mostrarDetallesVideojuego($_GET['titulo_clave']))){
    header("Location: vista_videojuegos.php");
}

if($_POST['eliminar']){
    $datosVideojuego = videojuegoDatos($_GET['titulo_clave']);
    if($datosVideojuego['nombre_usuario'] === $_SESSION['nombre_usuario']){
        eliminarVideojuego($datosVideojuego['titulo_clave']);
        header("Location: vista_videojuegos.php");
    }
}


if($_POST['salir']){
    cerrarSesion();
}

?>
    <h1 style="text-align:center;">Detalles de videojuego</h1>
    <?php echo $detallesVideojuego?>

    <div style="margin-left: 15px;">
    <?php if ($_SESSION['nombre_usuario']): ?>
    <form method="POST">
        <label for="salir">Pulse en el boton para salir de su cuenta.</label>
        <br>
        <button name="salir" id="salir" value="true" type="submit">Salir de la cuenta</button>
    </form>
    <?php endif; ?>
</div>
<?php
include "./caracteristicas/utilidades/footer.php";