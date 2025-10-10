<?php
include "./modulos/datos_servidor.php";

try {
    $conn = new PDO("mysql:host=$servername;dbname=biblioteca_videojuegos", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Usuarios ya existentes (los alternaremos)
    $usuarios = ['mario','luigi','peach','toad','bowser','zelda','link','samus','kirby','donkeykong'];

    // Valores fijos para todos
    $caratulaComun = 'default.png';
    $urlComun      = './caratulas/default.png';

    // Un juego por categoría existente
    $videojuegos = [
        ['titulo_clave'=>'doom-1993-fps',        'titulo'=>'DOOM (1993)',        'descripcion'=>'Clasico FPS seminal.',                'autor'=>'id Software',      'categoria_clave'=>'fps',         'fecha'=>'1993-12-10'],
        ['titulo_clave'=>'super-mario-plats',    'titulo'=>'Super Mario Bros.',  'descripcion'=>'Plataformas iconico.',               'autor'=>'Nintendo',         'categoria_clave'=>'plataformas', 'fecha'=>'1985-09-13'],
        ['titulo_clave'=>'sf2-lucha',            'titulo'=>'Street Fighter II',  'descripcion'=>'Pilar de los juegos de lucha.',      'autor'=>'Capcom',           'categoria_clave'=>'lucha',       'fecha'=>'1991-02-06'],
        ['titulo_clave'=>'witcher3-rpg',         'titulo'=>'The Witcher 3',      'descripcion'=>'RPG de mundo abierto.',              'autor'=>'CD Projekt',       'categoria_clave'=>'rpg',         'fecha'=>'2015-05-19'],
        ['titulo_clave'=>'uncharted2-aventura',  'titulo'=>'Uncharted 2',        'descripcion'=>'Aventura cinematografica.',          'autor'=>'Naughty Dog',      'categoria_clave'=>'aventura',    'fecha'=>'2009-10-13'],
        ['titulo_clave'=>'minecraft-sandbox',    'titulo'=>'Minecraft',          'descripcion'=>'Sandbox de construccion y aventura.', 'autor'=>'Mojang',           'categoria_clave'=>'sandbox',     'fecha'=>'2011-11-18'],
        ['titulo_clave'=>'fifa14-deportes',      'titulo'=>'FIFA 14',            'descripcion'=>'Simulacion de futbol.',              'autor'=>'EA Sports',        'categoria_clave'=>'deportes',    'fecha'=>'2013-09-23'],
        ['titulo_clave'=>'nfs-carreras',         'titulo'=>'Need for Speed',     'descripcion'=>'Clasico de carreras arcade.',        'autor'=>'EA',               'categoria_clave'=>'carreras',    'fecha'=>'1994-08-31'],
        ['titulo_clave'=>'starcraft-estrategia', 'titulo'=>'StarCraft',          'descripcion'=>'RTS de referencia.',                 'autor'=>'Blizzard',         'categoria_clave'=>'estrategia',  'fecha'=>'1998-03-31'],
        ['titulo_clave'=>'the-sims-simulacion',  'titulo'=>'The Sims',           'descripcion'=>'Simulacion de vida.',                'autor'=>'Maxis',            'categoria_clave'=>'simulacion',  'fecha'=>'2000-02-04'],
        ['titulo_clave'=>'cities-gestion',       'titulo'=>'Cities: Skylines',   'descripcion'=>'Gestion y planificacion urbana.',    'autor'=>'Colossal Order',   'categoria_clave'=>'gestion',     'fecha'=>'2015-03-10'],
    ];

    // Preparar sentencia
    $sql = "INSERT INTO videojuegos (
        titulo_clave, titulo, descripcion, autor, caratula,
        categoria_clave, url, fecha, nombre_usuario
    ) VALUES (
        :titulo_clave, :titulo, :descripcion, :autor, :caratula,
        :categoria_clave, :url, :fecha, :nombre_usuario
    )";
    $stmt = $conn->prepare($sql);

    $conn->beginTransaction();

    foreach ($videojuegos as $i => $v) {
        $v['caratula']       = $caratulaComun;
        $v['url']            = $urlComun;
        $v['nombre_usuario'] = $usuarios[$i % count($usuarios)]; // alternar usuarios

        $stmt->execute([
            ':titulo_clave'   => $v['titulo_clave'],
            ':titulo'         => $v['titulo'],
            ':descripcion'    => $v['descripcion'],
            ':autor'          => $v['autor'],
            ':caratula'       => $v['caratula'],
            ':categoria_clave'=> $v['categoria_clave'],
            ':url'            => $v['url'],
            ':fecha'          => $v['fecha'],     
            ':nombre_usuario' => $v['nombre_usuario'],
        ]);
    }

    $conn->commit();
} catch (PDOException $e) {
    if ($conn && $conn->inTransaction()) { $conn->rollBack(); }
    echo "<h3>Error al insertar videojuegos:</h3> " . $e->getMessage();
}