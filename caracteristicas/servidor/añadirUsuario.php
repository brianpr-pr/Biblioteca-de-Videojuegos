<?php

function añadirUsuario($nombreUsuario,$emailUsuario, $contraseñaUsuario, $imagenPerfil){
include "./caracteristicas/servidor/datos_servidor.php";

try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", 
        $username, 
        $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO usuarios (nombre_usuario, email, passwrd, imagen_perfil)
        VALUES (:nombre_usuario, :email, :passwrd, :imagen_perfil)");
        $stmt->bindParam(':nombre_usuario', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':passwrd', $passwrd);
        $stmt->bindParam(':imagen_perfil', $imagen_perfil);

        // insert a row
        $nombre = $nombreUsuario;
        $email = $emailUsuario;
        $passwrd = password_hash($contraseñaUsuario, PASSWORD_DEFAULT);
        $imagen_perfil = $imagenPerfil;
        $stmt->execute();
    } catch(PDOException $e) {
        echo "{$e->getMessage()}<br>{$errorMensaje}";
    }
}


function editarUsuario($nombreUsuario,$emailUsuario, $contraseñaUsuario, $imagenPerfil){
    try {
        include "./caracteristicas/servidor/datos_servidor.php";
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", 
        $username, 
        $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("UPDATE usuarios SET 
        nombre_usuario=:nombre_usuario,
        passwrd=:passwrd, 
        imagen_perfil=:imagen_perfil WHERE email=:email");
        $passwrd = password_hash($contraseñaUsuario, PASSWORD_DEFAULT);

        $stmt->execute([
            'nombre_usuario' => $nombreUsuario,
            'email' => $emailUsuario, 
            'passwrd' => $passwrd,
            'imagen_perfil'=> $imagenPerfil
        ]);
    } catch(PDOException $e) {
        echo "{$e->getMessage()}<br>{$errorMensaje}";
    }
}