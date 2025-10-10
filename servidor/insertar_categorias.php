<?php
include "./modulos/datos_servidor.php";

try {
    // Conexión a la base de datos existente
    $conn = new PDO("mysql:host=$servername;dbname=biblioteca_videojuegos", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Sentencia de inserción
    $sentenciaInsertCategorias = "
    INSERT INTO categorias (categoria_clave, numero_juegos_per_categoria) VALUES
    ('fps', 0),
    ('plataformas', 0),
    ('lucha', 0),
    ('rpg', 0),
    ('aventura', 0),
    ('sandbox', 0),
    ('deportes', 0),
    ('carreras', 0),
    ('estrategia', 0),
    ('simulacion', 0),
    ('gestion', 0);
    ";

    // Ejecutar inserción
    $conn->exec($sentenciaInsertCategorias);

} catch(PDOException $e) {
    echo "<h3>Error al insertar categorías:</h3> " . $e->getMessage();
}

// Cerrar conexión
$conn = null;