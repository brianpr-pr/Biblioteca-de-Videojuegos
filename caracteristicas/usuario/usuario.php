<?php
function salirUsuario(){
    $_SESSION['nombre_usuario'] = null;
    $_SESSION['email_usuario'] = null;
    header("");
}

function mostrarImagenPerfil(){
    try {
        include "./caracteristicas/servidor/datos_servidor.php";
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", 
        $username, 
        $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT imagen_perfil from usuarios 
        WHERE nombre_usuario=:nombre_usuario");
        $stmt->execute(['nombre_usuario' => $_SESSION['nombre_usuario']]);

        if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $conn = null;
            return $row['imagen_perfil'];
        }
        $conn = null;
        return false;

    } catch(PDOException $e) {
        echo "{$e->getMessage()}<br>{$errorMensaje}";
    }
}