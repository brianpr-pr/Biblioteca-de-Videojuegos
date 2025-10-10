<?php
session_start();
error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', 1);
$nombreArchivo = basename(path: __FILE__);
include "./utilidades/header.php";
include "./modulos/datos_servidor.php";
$errorMensaje = "";
$validForm = true;

//What to do with the sessions:

if($_SESSION['nombre_usuario']){
    header("Location: ./iniciado.php");
}

if(emailValidacion( $_POST['email'] ) ){
    $_SESSION['email'] = $_POST['email'];
} else{
    $_SESSION['email'] = null;
    $validForm = false;
    $errorMensaje = "{$errorMensaje}<h2>Email no es correcto.</h2><br>";
}

if(contraseñaComprobacion($_POST['email'],$_POST['passwrd'])){
    $_SESSION['passwrd'] = $_POST['passwrd'];
} else{
    $_SESSION['passwrd'] = null;
    $validForm = false;
    $errorMensaje = "{$errorMensaje}<h2>Las contraseñas no es correcta.</h2><br>";
}
?>


<div>
    <form accept="utf-8" method="POST">
        <h2>Inicio de sesión</h2>
        <br>
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
            title="Debe tener al menos 8 caracteres, incluyendo una letra y un número"
        >
        <br><br>
        <!-- Botón de envío -->
        <button value="true" name="enviarInicio" type="submit">Enviar</button>
    </form>    
</div>


<?php


if($validForm){
    header("Location: ./iniciado.php");
}
if($_POST['enviarInicio']){
echo "<h2>{$errorMensaje}</h2>";
}
function emailValidacion($emailUsuario){
        $resultado = filter_var($emailUsuario, FILTER_VALIDATE_EMAIL);
        if($resultado){
            include "./modulos/datos_servidor.php";
            
            try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    // Preparacion sentencias SQL
                    $stmt = $conn->prepare("SELECT email FROM usuarios WHERE email=:emailArgumento");
                    $stmt->bindParam(':emailArgumento', $emailUsuario, PDO::PARAM_STR);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $conn = null;
                    if($row){
                        return true;
                    }
                } catch(PDOException $e) {
                    echo "<br>" . $e->getMessage();
                }
                $conn = null;
        }
        return false;
    }

function contraseñaComprobacion($email,$passwrd){
    include "./modulos/datos_servidor.php";
    try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // Preparacion sentencias SQL
            $stmt = $conn->prepare("SELECT nombre_usuario,email,passwrd FROM usuarios WHERE email=:email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            //$conn = null;
            if($row){
                if(password_verify($passwrd, $row['passwrd'])){
                    $_SESSION['nombre_usuario']=$row['nombre_usuario'];
                    $_SESSION['email_usuario']=$row['email'];
                    return true;
                }
            }
        } catch(PDOException $e) {
            echo "<br>" . $e->getMessage();
        }
    $conn = null;
    return false;
}

include "./utilidades/footer.php"?>