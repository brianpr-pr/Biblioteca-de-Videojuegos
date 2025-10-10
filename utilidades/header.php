<?php
include "./modulos/hojas_estilo_vinculador.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Biblioteca de videojuegos</title>
    <link rel="stylesheet" href='<?php echo vincularHojaEstilo($nombreArchivo)?>'>
    <link rel="stylesheet" href='./estilos/estilo_general.css'>
</head>
<body>
    <header>
        <a href="index.php">Inicio</a>
        <a href="registro.php">Registro</a>
        <a href="inicio_sesion.php">Inicio de sesión</a>
        <a href="vista_videojuegos.php">Biblioteca de videojuegos</a>
        <a href="añadir_videojuego.php">Añadir videojuego</a>
    </header>
<?php include "./modulos/conectar.php";?>