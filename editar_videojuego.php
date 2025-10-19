<?php
// editar_videojuego.php
session_start();
error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', 1);
$nombreArchivo = basename(path: __FILE__);
require "./caracteristicas/utilidades/header.php";
require "./caracteristicas/servidor/administrarVideojuegos.php";
require "./caracteristicas/validacion/validacionVideojuego.php";
include "./caracteristicas/cookies/manejo_tokens.php";
include_once "./caracteristicas/usuario/usuario.php";
// Variable para comprobar que la enviar la solicitud POST se hallan superado 
// Todas las validaciones.
$test = true;
$feedback = '';


if (empty($_SESSION['nombre_usuario'])) {
    // intenta validar la cookie y obtener el username
    $pdo = db_connect();
    $username = validateRememberCookie($pdo); // devuelve username o null

    if ($username) {
        $_SESSION['nombre_usuario'] = $username;
    }
}


if($_GET['salir']){
    salirUsuario();
}




if(!$_SESSION['nombre_usuario']){
    header("Location: ./inicio_sesion.php?error=Es necesario que inicie sesión antes de poder editar un videojuego");
}

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    if(array_key_exists('titulo_clave', $_GET)){
        $datosVideojuego = videojuegoDatos($_GET['titulo_clave']);
    }

    if($datosVideojuego['nombre_usuario'] === $_SESSION['nombre_usuario']){
        $_GET['titulo'] = $datosVideojuego['titulo'];
        $_GET['autor'] = $datosVideojuego['autor'];
        $_GET['descripcion'] = $datosVideojuego['descripcion'];
        $_GET['categoria_clave'] = $datosVideojuego['categoria_clave'];
        $_GET['url'] = $datosVideojuego['url'];
        $_GET['fecha'] = $datosVideojuego['fecha'];
        $_GET['nombre_usuario'] = $datosVideojuego['nombre_usuario'];
        $_GET['titulo_modificar'] = $datosVideojuego['titulo_clave'];
    } else{
        $_GET = null;
    }
} else{
    $_GET = null;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    if(!tituloValidacion($_POST['titulo'], $_SESSION['nombre_usuario'])){
        $_GET['titulo'] = null;
        $test = false;
        $feedback = "<h2>Titulo incorrecto</h2><br>";
    }

    if(!autorValidacion($_POST['autor'])){
        $_GET['autor'] = null;
        $test = false;
        $feedback = "<h2>Autor incorrecto</h2><br>";
    }

    if(!descripcionValidacion($_POST['descripcion'])){
        $_GET['descripcion'] = null;
        $test = false;
        $feedback = "<h2>Descripción incorrecta</h2><br>";
    }

    if(!categoriaValidacion($_POST['categoria'])){
        $_GET['categoria'] = null;
        $test = false;
        $feedback = "<h2>Categoria incorrecta</h2><br>";
    }

    if(!fechaValidacion($_POST['fecha'])){
        $_GET['fecha'] = null;
        $test = false;
        $feedback = "<h2>Fecha incorrecta</h2><br>";
    }

    try {
        if(!caratulaValidacion()){
            $test = false;
            $feedback = "<h2>Caratula incorrecta</h2><br>";
        }
    } catch(Exception $e){
        echo "<br><h1>" . $e->getMessage() . "</h1>";
    }

    if($test){
        modificarVideojuego();
        $feedback = "<h2>Consulta terminada de manera exitosa.</h2>";
    } else {
        eliminarCaratula($_POST['url']);
        $feedback ="<h2>Error, no se puedo realizar consulta a la base de datos por validación de datos incorrecta.</h2><br>{$feedback}";
    }
}

?>

<div style="margin-left: 25px;">
    <h2>Editar videojuego</h2>
    <h4>Propietario: <?php echo $s;?></h4>
    <form method="POST" enctype="multipart/form-data">
        <div>
            <!-- Titulo videojuego-->
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
                pattern="[A-Za-z0-9_. ]{1,40}"
                title="Solo se admiten letras, números, guiones bajos y puntos 
                (mínimo 1 caracter, máximo 40)"
            />
            <!-- Autor videojuego-->
            <label for="autor">Autor</label>
            <input
                value="<?php echo $_GET['autor'] ?? ''; ?>"
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
        <!-- Descripción videojuego -->
        <label for="descripcion">Descripción</label>
        <br><br>
        <textarea
            style="padding:0px;"
            placeholder="Ingrese una descripción del titulo"
            name="descripcion"
            id="descripcion"
            rows="6"
            cols="40"
            required
            minlength="3"
            maxlength="100"
            pattern="[A-Za-z0-9_. ]{3,100}"
            title="Solo se admiten letras, números, guiones bajos, puntos y espacios en blanco 
            (mínimo 3 caracteres, máximo 100)
        "><?php echo $_GET['descripcion'] ?? ''; ?></textarea>
        <br><br>
        <div>
            <!--Categoria-->
            <label for="categoria">Categoría</label>
            <select name="categoria">
                <?php echo mostrarCategorias()?>
            </select>
            <!--Fecha-->
            <label for="fecha">Fecha</label>
            <input 
            value="<?php echo $_GET['fecha']; ?>"
            name="fecha" id="fecha" type="date"/>
        </div>
        <br><br>
        <div>
            <!--Imagen Caratula-->
            <label for="imagen">Imagen de caratula</label>
            <input type="text" name="titulo_modificar" value="<?php echo $_GET['titulo_modificar']; ?>" readonly style="display:none;">
            <input
                id="imagen"
                name="imagen"
                type="file"
                accept="image/jpeg, image/png, image/gif"
                title="Solo se aceptan archivos de tamaño maximo: 1MB; tipo: png, jpeg, gif;"
            />
        </div>
        <br><br>
        <label for="nombre_usuario">Subido por</label>
        <input
        readonly
        value="<?php echo $_GET['nombre_usuario']; ?>"
        name="nombre_usuario" id="nombre_usuario" 
        type="text" />
        <br><br>
        <div>
            <button name="" value="" type="submit">Guardar cambios</button>
            <button name="" value="" type="reset">Cancelar</button>
        </div>
    </form>
</div>
<br><br>
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
//Información sobre el resultado de la actualización de datos:
echo $feedback;

include "./caracteristicas/utilidades/footer.php";