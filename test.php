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

/*
if($_GET['salir']){
    salirUsuario();
}*/

if(!$_SESSION['nombre_usuario']){
    header("Location: ./inicio_sesion.php?error=Es necesario que incie sesion antes de poder editar un videojuego");
}

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
} 

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(tituloValidacion($_POST['titulo'], $_SESSION['nombre_usuario'])){
        echo "Titulo es correcto";
    }
}

?>

<div style="margin-left: 25px;">
    <h2>Editar videojuego</h2>
    <h4>Propietario: <?php echo $s;?></h4>
    <form method="POST">
        <div>
            <label for="titulo">Título</label>
            <input
                value="<?php echo $_GET['titulo']; ?>"
                placeholder="Ingrese un titulo"
                name="titulo" 
                id="titulo" 
                type="text"
                required
                minlength="1"
                maxlength="40"
                pattern="[A-Za-z0-9_.]{1,40}"
                title="Solo se admiten letras, números, guiones bajos y puntos 
                (mínimo 1 caracter, máximo 40)"
            />
        </div>
    </form>
</div>

<div style="margin-left: 15px;">
    <?php if ($_SESSION['nombre_usuario']): ?>
    <form method="GET">
        <label for="salir">Pulse en el boton para salir de su cuenta.</label>
        <br>
        <button name="salir" id="salir" value="true" type="send">Salir de la cuenta</button>
    </form>
    <?php endif; ?>
</div>

<?php
include "./caracteristicas/utilidades/footer.php";