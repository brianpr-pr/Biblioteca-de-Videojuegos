<?php
session_start();
error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', 1);
$nombreArchivo = basename(path: __FILE__);
include "./caracteristicas/utilidades/header.php";
include "./caracteristicas/servidor/añadirUsuario.php";
include "./caracteristicas/validacion/validacionUsuario.php";
include "./caracteristicas/servidor/eliminar_base_datos.php";
include "./caracteristicas/cookies/manejo_tokens.php";


?>

<div>
    <form accept="utf-8" method="POST">
        <h2>Crear mockup usuario</h2>
        <!-- Botón de envío -->
        <input hidden value="true" name="crear"/>
        <button type="submit">Enviar</button>
    </form>

    <form accept="utf-8" method="POST">
        <h2>Eliminar base de datos</h2>
        <!-- Botón de envío -->
        <input hidden value="true" name="eliminar"/>
        <button type="submit">Eliminar</button>
    </form>
</div>


<?php
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if($_POST['crear']){
        añadirUsuario("test","email@gmail.com", "1234567890a", "./perfil/default.png");
        //Una vez que el usuario ha iniciado sesión correctamente generamos token.
        
        try{
            $pdo =  db_connect();
            $token = createRememberToken($pdo, "test", 7);
            setRememberCookie($token);
            header(header: "Location: ./iniciado.php");
        } catch(Exception $e){
            echo "Error: $e";
        }
        
    } elseif($_POST['eliminar']){
        eliminarBaseDatos();
    }
    
} else{
    echo "Usuario no se ha editado.";
}

include "./caracteristicas/utilidades/footer.php";