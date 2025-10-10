<?php
function vincularHojaEstilo($nombreArchivo) {
    $pathGeneral = "./../../estilos/";
    return match ($nombreArchivo) {
        "añadir_videojuego.php" => "{$pathGeneral}estilo_añadir_videojuego.css",
        "editar_videojuego.php" => "{$pathGeneral}estilo_editar_videojuego.css",
        "index.php" => "{$pathGeneral}estilo_index.css",
        "iniciado.php" => "{$pathGeneral}estilo_iniciado.css",
        "inicio_sesion.php" => "{$pathGeneral}estilo_inicio_sesion.css",
        "registro.php" => "{$pathGeneral}estilo_registro.css",
        "vista_detalles_videojuego.php" => "{$pathGeneral}estilo_vista_detalles_videojuego.css",
        "vista_videojuegos.php" => "{$pathGeneral}estilo_vista_videojuegos.css",
        default => "{$pathGeneral}estilo_index.css",
    };
}