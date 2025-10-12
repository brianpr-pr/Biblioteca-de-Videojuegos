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

if($_GET['salir']){
    salirUsuario();
}

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
    if(tituloValidacion($_POST['titulo'])){
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
                title="Solo se admiten letras, números, guiones bajos y puntos (mínimo 1 caracter, máximo 40)"
            />
            <label for="autor">Autor</label>
            <input 
                value="<?php echo $_GET['autor']; ?>"
                placeholder="Ingrese el autor"
                name="autor"
                id="autor"
                type="text"
                required
                minlength="1"
                maxlength="35"
                pattern="[A-Za-z]{1,35}"
                title="Solo se admiten letras (mínimo 1 caracter, máximo 35)"
            />
        </div>
        <br>
        <label for="descripcion">Descripción</label>
        <br><br>
        <textarea
            value="<?php echo $_GET['descripcion']; ?>"
            placeholder="Ingrese una descripción del titulo"
            name="descripcion"
            id="descripcion"
            rows="6"
            cols="40"
            required
            minlength="3"
            maxlength="100"
            pattern="[A-Za-z0-9_.]{3,100}"
            title="Solo se admiten letras, números, guiones bajos y puntos (mínimo 3 caracteres, máximo 100)"    
        >
        </textarea>

        <br><br>
        <div>
            <label for="categoria">Categoría</label>
            <select>
                <?php echo mostrarCategorias()?>
            </select>
            <label for="fecha">Fecha</label>
            <input 
            value="<?php echo $_GET['fecha']; ?>"
            name="fecha" id="fecha" type="date"/>
        </div>
        <br><br>
        <div>
            <label for="caratula">Nombre de archivo</label>
            <input 
                value="<?php echo $_GET['caratula']; ?>"
                name="caratula" 
                id="caratula" 
                type="text"
                maxlength="45"
                pattern="[A-Za-z0-9_.]{0,45}"
                title="Solo se admiten letras, números, guiones bajos y puntos (máximo 45)"
            />
            <br><br>
            <label for="caratula">Imagen de caratula</label>
            <input 
                value="<?php echo $_GET['url']; ?>"
                id="imagen" 
                name="imagen" 
                type="file" 
                accept="image/jpg, image/png"
            />
        </div>
        <br><br>
        <label for="nombre_usuario">Subido por</label>
        <input 
        value="<?php echo $_GET['nombre_usuario']; ?>"
        name="nombre_usuario" id="nombre_usuario" type="text" placeholder=""/>
        <br><br>
        <div>
            <button name="" value="" type="">Cancelar</button>
            <button name="" value="" type="">Guardar cambios</button>
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