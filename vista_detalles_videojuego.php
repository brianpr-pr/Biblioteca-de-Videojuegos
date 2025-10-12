<?php
session_start();
error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', 1);
$nombreArchivo = basename(path: __FILE__);
include "./caracteristicas/utilidades/header.php";
require "./caracteristicas/servidor/administrarVideojuegos.php";

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

?>
    <h1 style="text-align:center;">Detalles de videojuego</h1>
    <?php echo $detallesVideojuego?>
<?php
include "./caracteristicas/utilidades/footer.php";