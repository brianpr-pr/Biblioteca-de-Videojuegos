<?php
include "./caracteristicas/servidor/datos_servidor.php";

try {
    // Conexión a la base de datos existente
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Contraseña base
    $passwordPlano = "1234567890a";
    $passwordHash = password_hash($passwordPlano, PASSWORD_DEFAULT);
    $imagenPerfil = "./perfil/default.png"; 

    // Lista de usuarios para insertar
    $usuarios = [
        ['nombre_usuario' => 'mario',     'email' => 'mario@example.com'],
        ['nombre_usuario' => 'luigi',     'email' => 'luigi@example.com'],
        ['nombre_usuario' => 'peach',     'email' => 'peach@example.com'],
        ['nombre_usuario' => 'toad',      'email' => 'toad@example.com'],
        ['nombre_usuario' => 'bowser',    'email' => 'bowser@example.com'],
        ['nombre_usuario' => 'zelda',     'email' => 'zelda@example.com'],
        ['nombre_usuario' => 'link',      'email' => 'link@example.com'],
        ['nombre_usuario' => 'samus',     'email' => 'samus@example.com'],
        ['nombre_usuario' => 'kirby',     'email' => 'kirby@example.com'],
        ['nombre_usuario' => 'donkeykong','email' => 'donkeykong@example.com']
    ];

    // Preparar sentencia
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre_usuario, email, passwrd, imagen_perfil) VALUES (:nombre, :email, :pass, :imagen_perfil)");

    // Insertar todos los usuarios
    foreach ($usuarios as $u) {
        $stmt->execute([
            ':nombre' => $u['nombre_usuario'],
            ':email'  => $u['email'],
            ':pass'   => $passwordHash,
            ':imagen_perfil' => $imagenPerfil
        ]);
    }

} catch(PDOException $e) {
    echo "<h3>Error al insertar usuarios:</h3> " . $e->getMessage();
}

$conn = null;
