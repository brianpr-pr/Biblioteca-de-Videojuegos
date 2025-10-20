<?php
session_start();
error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', 1);
$nombreArchivo = basename(path: __FILE__);
require "./caracteristicas/utilidades/header.php";
require "./caracteristicas/servidor/administrarVideojuegos.php";
include_once "./caracteristicas/usuario/usuario.php";
include "caracteristicas/cookies/manejo_tokens.php";



if (empty($_SESSION['nombre_usuario'])) {
    // intenta validar la cookie y obtener el username
    $pdo = db_connect();
    $username = validateRememberCookie($pdo); // devuelve username o null

    if ($username) {
        $_SESSION['nombre_usuario'] = $username;
    }
}

if(!$_SESSION['nombre_usuario']){
    header("Location: ./inicio_sesion.php?error=Es necesario que inicie sesión antes de poder ver la colección de videojuegos");
}

if($_GET['salir']){
    cerrarSesion();
}

?>


<h2>Colección de videojuegos</h2>

<label for="buscador">Buscar titulo</label>
<input type="text" id="buscador" name="buscador" placeholder="Ingrese el titulo del videojuego que busca." style="width:250px;">
<br><br><br>
<p id="test"></p>

<table id="busqueda"></table>

<br>
<table id="tabla">
    <tr>
        <th>Caratula</th>
        <th>Título</th>
        <th>Fecha de lanzamiento</th>
    </tr>
    <?php echo mostrarVideojuegos();?>
</table>
<br><br>
<div style="margin-left: 15px;">
    <?php if ($_SESSION['nombre_usuario']): ?>
    <form method="GET">
        <label for="salir">Pulse en el boton para salir de su cuenta.</label>
        <br>
        <button name="salir" id="salir" value="true" type="send">Salir de la cuenta</button>
    </form>
    <?php endif; ?>
</div>
<script>
    function mostrarListaVideojuegos(titulo) {
  if (titulo.length == 0) {
    document.getElementById("busqueda").innerHTML = "";
    document.getElementById("tabla").style.display = "block";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("busqueda").innerHTML = this.responseText;
        document.getElementById("tabla").style.display = "none";
      }
    };
    xmlhttp.open("GET", "./caracteristicas/buscador/mostrar_titulos.php?titulo=" + titulo);
    xmlhttp.send();
  }
}


document.getElementById('buscador').addEventListener("input", event => {
    mostrarListaVideojuegos(event.target.value);
});

</script>


<?
include "./caracteristicas/utilidades/footer.php";