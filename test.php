<?php
// editar_videojuego.php
session_start();
error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', 1);
$nombreArchivo = basename(path: __FILE__);
require "./caracteristicas/utilidades/header.php";
require "./caracteristicas/servidor/administrarVideojuegos.php";
require "./caracteristicas/validacion/validacionVideojuego.php";

include_once "./caracteristicas/usuario/usuario.php";


/*if($_GET['salir']){
    salirUsuario();
}*/

/*
if(!$_SESSION['nombre_usuario']){
    header("Location: ./inicio_sesion.php?error=Es necesario que incie sesion antes de poder editar un videojuego");
}*/

/*
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    if(array_key_exists('titulo_clave', $_GET)){
        $datosVideojuego = videojuegoDatos($_GET['titulo_clave']);
    }

    if($datosVideojuego['nombre_usuario'] === $_SESSION['nombre_usuario']){
        $_GET['titulo'] = $datosVideojuego['titulo'];
        $_GET['autor'] = $datosVideojuego['autor'];
        $_GET['descripcion'] = $datosVideojuego['descripcion'];
        $_GET['caratula'] = $datosVideojuego['caratula'];
        $_GET['categoria_clave'] = $datosVideojuego['categoria_clave'];
        $_GET['url'] = $datosVideojuego['url'];
        $_GET['fecha'] = $datosVideojuego['fecha'];
        $_GET['nombre_usuario'] = $datosVideojuego['nombre_usuario'];
    } else{
        $_GET = null;
    }
} */

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(caratulaValidacion($_FILES['imagen'])){
        echo "<br><h1>Exito</h1>";
    }
}

?>

    <h2>Editar videojuego</h2>
    <h4>Propietario: <?php echo $s;?></h4>
    <form method="POST" enctype="multipart/form-data">
        <div>
            <label for="imagen">Imagen de caratula</label>
            <!--<input type="hidden" name="MAX_FILE_SIZE" value="1048576">-->
            <input
                id="imagen"
                name="imagen"
                type="file" 
                accept="image/jpeg, image/png"
            />
        </div>
        <br><br>
         <div>
            <button name="" value="" type="">Guardar cambios</button>
        </div>
    </form>
</div>

<div style="margin-left: 15px;">
    <?php if ($_SESSION['nombre_usuario']): ?>
    <form method="GET">
        <label for="salir">Pulse en el boton para salir de su cuenta.</label>
        <br>
        <button name="salir" id="salir" value="true" type="submit">Salir de la cuenta</button>
    </form>
    <?php endif; ?>
</div>

<?php
include "./caracteristicas/utilidades/footer.php";