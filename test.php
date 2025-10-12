<?php
// editar_videojuego.php
session_start();
error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', 1);
$nombreArchivo = basename(path: __FILE__);
include "./caracteristicas/utilidades/header.php";
include "./caracteristicas/servidor/datos_servidor.php";
?>

<div>
    <h2>Editar videojuego</h2>
    <h4>Propietario: </h4>
    <form>
        <div>
            <label for="categoria">Categoría</label>
            <select id="categoria" name="categoria">
                <option>A</option>
                <option>B</option>
                <option>C</option>
            </select>
        </div>
    </form>
</div>

<?php
include "./caracteristicas/utilidades/footer.php";