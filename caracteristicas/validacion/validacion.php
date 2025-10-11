<?php
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

function inicioSesion($emailUsuario, $contraseña){
        if(filter_var($emailUsuario, FILTER_VALIDATE_EMAIL)){
            include "./caracteristicas/servidor/datos_servidor.php";
            
            try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    // Preparacion sentencias SQL
                    $stmt = $conn->prepare("SELECT nombre_usuario, email, passwrd FROM usuarios WHERE email = :emailArgumento LIMIT 1");
                    $stmt->execute(["emailArgumento" => $emailUsuario]);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if($row){ 
                        if(password_verify($contraseña, $row['passwrd'])){
                            $_SESSION['nombre_usuario'] = $row['nombre_usuario'];
                            $_SESSION['email_usuario'] = $row['email'];
                            $conn = null;
                            return true;
                        } else{
                            echo "La contraseña no coincide papa";
                        }
                    }
            } catch(PDOException $e) {
                    echo "<br>" . $e->getMessage();
            }
            $conn = null;
        }
    return false;
}