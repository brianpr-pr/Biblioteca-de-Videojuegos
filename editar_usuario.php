<?php
session_start();
error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', 1);
$nombreArchivo = basename(path: __FILE__);
include "./caracteristicas/utilidades/header.php";
include "./caracteristicas/servidor/añadirUsuario.php";
include "./caracteristicas/validacion/validacionUsuario.php";
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
    header("Location: ./inicio_sesion.php");
}

$datosUsuario = getDatosUsuario($_SESSION['nombre_usuario']);
$_SESSION['email'] = $datosUsuario['email'];
$_SESSION['imagen_anterior'] = $datosUsuario['imagen_perfil']; 
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if(!nombreUsuarioValidacion($_POST['nombre_usuario']) 
        && $_SESSION['nombre_usuario'] !== $_POST['nombre_usuario']){
        $_SESSION['error'] = "{$_SESSION['error']}<h2>Nombre de usuario es invalido, por favor ingrese un nombre de usuario valido.</h2><br>";
    } else {
        $_SESSION['nombre_usuario'] = $_POST['nombre_usuario'];
    }

    if(contraseñaValidacion($_POST['contraseñaUno'],$_POST['contraseñaDos'])){
        $_SESSION['contraseñaUno'] = $_POST['contraseñaUno'];
        $_SESSION['contraseñaDos'] = $_POST['contraseñaDos'];
    } else{
        $_SESSION['contraseñaUno'] = null;
        $_SESSION['contraseñaDos'] = null;
        $_SESSION['error'] = "{$_SESSION['error']}<h2>Las contraseñas no coinciden porfavor ingreselas de nuevo.</h2><br>";
    }
    
    try{
        if(perfilValidacion()){
            $_SESSION['imagen_perfil'] = $_POST['imagen'];
        } else{
            $_SESSION['imagen_perfil'] = null;
        }
    } catch(Exception $e){
        $_SESSION['imagen_perfil'] = null;
    }

}
?>


<div>
    <form accept="utf-8" method="POST" enctype="multipart/form-data">
        <h2>Editar datos del perfil</h2>
        <br>
        <!-- Nombre de usuario -->
        <label for="nombre_usuario">Nombre usuario</label>
        <br>
        <input
            placeholder="Ingrese su nombre de usuario." 
            type="text"
            name="nombre_usuario"
            id="nombre_usuario"
            value="<?php echo $_SESSION['nombre_usuario'] ?? ''; ?>"
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
            placeholder="Ingrese su email." 
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
        <label for="contraseñaUno">Nueva Contraseña</label>
        <br>
        <input
            type="password"
            name="contraseñaUno"
            id="contraseñaUno"
            required
            required
            minlength="8"
            maxlength="20"
            pattern="[A-Za-z0-9]{8,20}"
            title="Debe tener al menos 8 caracteres, incluyendo una letra y un número.">
        <br><br>
        <!-- Confirmar contraseña -->
        <label for="contraseñaDos">Repite la contraseña</label>
        <br>
        <input
            type="password"
            name="contraseñaDos"
            id="contraseñaDos"
            required
            minlength="8"
            maxlength="20"
            pattern="[A-Za-z0-9]{8,20}"
            title="Debe coincidir con la contraseña anterior">
        <br><br>
        <!--Imagen Caratula-->
        <label for="imagen">Imagen de perfil</label>
        <input
            id="imagen"
            name="imagen"
            type="file"
            title="Solo se aceptan archivos de tamaño maximo: 3MB; tipo: png, jpeg, gif;"
        />
        <br><br>
        <!-- Botón de envío -->
        <button type="submit">Enviar</button>
    </form>    
</div>


<?php
if($_SESSION['nombre_usuario']  && $_SESSION['contraseñaUno'] && $_SESSION['contraseñaDos']){
    $_SESSION['error'] = null;
    if($_SESSION['imagen_perfil']){
        editarUsuario($_SESSION['nombre_usuario'],$_SESSION['email'], $_SESSION['contraseñaUno'], $_SESSION['imagen_perfil']);
    } else{
        editarUsuario($_SESSION['nombre_usuario'],$_SESSION['email'], $_SESSION['contraseñaUno'], $_SESSION['imagen_anterior']);
    }
    echo "Usuario se ha editado correctamente.";
    
    $_SESSION['contraseñaUno'] = null;
    $_SESSION['contraseñaDos'] = null;
    //header(header: "Location: ./iniciado.php");
} else{
    echo "Usuario no se ha editado.";
    echo $_SESSION['error'];
    $_SESSION['error'] = null;
}
include "./caracteristicas/utilidades/footer.php";