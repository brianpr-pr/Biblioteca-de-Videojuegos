<?php
session_start();
error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', 1);
$nombreArchivo = basename(path: __FILE__);
include "./caracteristicas/utilidades/header.php";
include "./caracteristicas/servidor/datos_servidor.php";
$errorMensaje = "";
$validForm = true;

//What to do with the sessions:
if($_SESSION['nombre_usuario']){
    header("Location: ./iniciado.php");
}


if(nombreUsuarioValidacion($_POST['nombreUsuario'])){
    $_SESSION['nombreUsuario'] = $_POST['nombreUsuario'];
} else{
    $_SESSION['nombreUsuario'] = null;
    $validForm = false;
    $errorMensaje = "<h2>Nombre de usuario es invalido, por favor ingrese un nombre de usuario valido.</h2><br>";
}

if(emailValidacion( $_POST['email'] ) ){
    $_SESSION['email'] = $_POST['email'];
} else{
    $_SESSION['email'] = null;
    $validForm = false;
    $errorMensaje = "{$errorMensaje}<h2>Email es invalido, por favor ingrese un email valido.</h2><br>";

}

if(contraseñaValidacion($_POST['passwrd'],$_POST['passwrdDos'])){
    $_SESSION['passwrd'] = $_POST['passwrd'];
    $_SESSION['passwrdDos'] = $_POST['passwrdDos'];
} else{
    $_SESSION['passwrd'] = null;
    $_SESSION['passwrdDos'] = null;
    $validForm = false;
    $errorMensaje = "{$errorMensaje}<h2>Las contraseñas no coinciden porfavor ingreselas de nuevo.</h2><br>";
}
?>

<div>
    <form method="POST">
        <h2>Registro</h2>
        <br>

        <!-- Nombre de usuario -->
        <label for="nombreUsuario">Nombre usuario</label>
        <br>
        <input
            type="text"
            name="nombreUsuario"
            id="nombreUsuario"
            value="<?php echo $_SESSION['nombreUsuario'] ?? ''; ?>"
            required
            minlength="3"
            maxlength="35"
            pattern="[A-Za-z0-9_]+"
            title="Solo letras, números y guiones bajos (mínimo 3 caracteres)"
        >
        <br><br>

        <!-- Email -->
        <label for="email">Email</label>
        <br>
        <input
            type="email"
            name="email"
            id="email"
            value="<?php echo $_SESSION['email'] ?? ''; ?>"
            required
            maxlength="40"
            title="Introduce un correo electrónico válido"
        >
        <br><br>

        <!-- Contraseña -->
        <label for="passwrd">Contraseña</label>
        <br>
        <input
            type="password"
            name="passwrd"
            id="passwrd"
            value="<?php echo $_SESSION['passwrd'] ?? ''; ?>"
            required
            minlength="8"
            maxlength="20"
            pattern="(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}"
            title="Debe tener al menos 8 caracteres, incluyendo una letra y un número">
        <br><br>
        <!-- Confirmar contraseña -->
        <label for="passwrdDos">Repite la contraseña</label>
        <br>
        <input
            type="password"
            name="passwrdDos"
            id="passwrdDos"
            value="<?php echo $_SESSION['passwrdDos'] ?? ''; ?>"
            required
            minlength="8"
            maxlength="20"
            pattern="(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}"
            title="Debe coincidir con la contraseña anterior">
        <br><br>

        <!-- Botón de envío -->
        <button type="submit">Enviar</button>
    </form>    
</div>
<?php 
if($validForm){
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", 
        $username, 
        $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO usuarios (nombre_usuario, email, passwrd)
        VALUES (:nombre_usuario, :email, :passwrd)");
        $stmt->bindParam(':nombre_usuario', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':passwrd', $passwrd);

        // insert a row
        $nombre = $_POST['nombreUsuario'];
        $email = $_POST['email'];
        $passwrd = password_hash($_POST['passwrd'], PASSWORD_DEFAULT);
        $stmt->execute();
        header("Location: ./inicio_sesion.php");
    } catch(PDOException $e) {
        echo "{$e->getMessage()}<br>{$errorMensaje}";
    }
}

$conn = null;

function nombreUsuarioValidacion($nombreUsuario){
            include "./caracteristicas/servidor/datos_servidor.php";
            try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    // Preparacion sentencias SQL
                    $stmt = $conn->prepare("SELECT nombre_usuario FROM usuarios WHERE nombre_usuario=:nombre_usuario");
                    $stmt->bindParam(':nombre_usuario', $nombreUsuario, PDO::PARAM_STR);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if(!$row){
                        return true;
                    }
                } catch(PDOException $e) {
                    echo "<br>" . $e->getMessage();
                }
                $conn = null;
        return false;
}


function emailValidacion($emailUsuario){
        $resultado = filter_var($emailUsuario, FILTER_VALIDATE_EMAIL);
        if($resultado){
            include "./caracteristicas/servidor/datos_servidor.php";
            
            try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    // Preparacion sentencias SQL
                    $stmt = $conn->prepare("SELECT email FROM usuarios WHERE email=:emailArgumento");
                    $stmt->bindParam(':emailArgumento', $emailUsuario, PDO::PARAM_STR);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if(!$row){
                        return true;
                    }
                } catch(PDOException $e) {
                    echo "<br>" . $e->getMessage();
                }
                $conn = null;
        }
        return false;
    }

function contraseñaValidacion($passwordUno,$passwordDos){
    if($passwordUno == $passwordDos){
        return true;
    }
    return false;
}

include "./caracteristicas/utilidades/footer.php"?>