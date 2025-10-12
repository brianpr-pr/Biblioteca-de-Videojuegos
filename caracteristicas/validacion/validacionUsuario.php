<?php
function nombreUsuarioValidacion($nombreUsuario){
    $estado = true;
    if(strlen($nombreUsuario) < 3 || strlen($nombreUsuario) > 35){
        $estado = false;
    }

    if(!preg_match('/^([a-zA-Z0-9._-])+$/', $nombreUsuario)){
        $estado = false;
    }

    if($estado){
        try {
            include "./caracteristicas/servidor/datos_servidor.php";
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // Preparacion sentencias SQL
            $stmt = $conn->prepare("SELECT nombre_usuario FROM usuarios WHERE nombre_usuario=:nombre_usuario");
            $stmt->execute(["nombre_usuario" => $nombreUsuario]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!$row){
                $conn = null;
                return true;
            }
        } catch(PDOException $e) {
            echo "<br>" . $e->getMessage();
        }
    }
    $conn = null;
    return false;
}


function emailValidacion($emailUsuario){
        $resultado = true;
        
        if(!filter_var($emailUsuario, FILTER_VALIDATE_EMAIL)){
            $resultado = false;
        }

        if(strlen($emailUsuario) > 40){
            $resultado = false;
        }

        if($resultado){
            include "./caracteristicas/servidor/datos_servidor.php";
            
            try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    // Preparacion sentencias SQL
                    $stmt = $conn->prepare("SELECT email FROM usuarios WHERE email=:emailArgumento");
                    $stmt->execute(['emailArgumento' => $emailUsuario]);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if(!$row){
                        $conn = null;
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
    $resultado = true;
    if($passwordUno !== $passwordDos){
        $resultado = false;
    }

    if(strlen($passwordUno) < 8 || strlen($passwordUno) > 20){
        $resultado = false;
    }

    if(!preg_match('/^[A-Za-z0-9]{8,}$/', $passwordUno)){
        $resultado = false;
    }

    return $resultado;
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
                        }
                    }
            } catch(PDOException $e) {
                    echo "<br>" . $e->getMessage();
            }
            $conn = null;
        }
    return false;
}