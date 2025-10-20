<?php
session_start();
error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', 1);
$nombreArchivo = basename(path: __FILE__);
include "./caracteristicas/utilidades/header.php";
require "./caracteristicas/servidor/administrarVideojuegos.php";
include "./caracteristicas/servidor/gestion_votos.php";
include "./caracteristicas/cookies/manejo_tokens.php";


if (empty($_SESSION['nombre_usuario'])) {
    // intenta validar la cookie y obtener el username
    $pdo = db_connect();
    $username = validateRememberCookie($pdo); // devuelve username o null

    if ($username) {
        $_SESSION['nombre_usuario'] = $username;
    }
}

if(!($detallesVideojuego = mostrarDetallesVideojuego($_GET['titulo_clave']))){
    header("Location: vista_videojuegos.php");
}

if($_POST['eliminar']){
    $datosVideojuego = videojuegoDatos($_GET['titulo_clave']);
    if($datosVideojuego['nombre_usuario'] === $_SESSION['nombre_usuario']){
        eliminarVideojuego($datosVideojuego['titulo_clave']);
        header("Location: vista_videojuegos.php");
    }
}


if($_POST['salir']){
    cerrarSesion();
}

?>
    <h1 style="text-align:center;">Detalles de videojuego</h1>
    <?php echo $detallesVideojuego?>

    <div id="votos-container" style="margin:15px;">
        <input type="hidden" id="titulo_clave" value="<?php echo htmlspecialchars($_GET['titulo_clave'], ENT_QUOTES); ?>">
        <div>
            <button id="like">👍 Like</button>
            <span name="contador_like" id="contador_like"><?php echo mostrarPuntuacion(htmlspecialchars($_GET['titulo_clave'], ENT_QUOTES),'like')?></span>
            &nbsp;&nbsp;
            <button id="dislike">👎 Dislike</button>
            <span id="contador_dislike" name="contador_dislike"><?php echo mostrarPuntuacion(htmlspecialchars($_GET['titulo_clave'], ENT_QUOTES),'dislike')?></span>
        </div>
        <div id="resultado" style="margin-top:8px;"></div>
    </div>

    <div style="margin-left: 15px;">
    <?php if ($_SESSION['nombre_usuario']): ?>
    <form method="POST">
        <label for="salir">Pulse en el boton para salir de su cuenta.</label>
        <br>
        <button name="salir" id="salir" value="true" type="submit">Salir de la cuenta</button>
    </form>
    <?php endif; ?>
    </div>
    
<script>
    function enviarVoto(valor){
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                document.getElementById("resultado").innerHTML = this.responseText;
            }
        };

        xmlhttp.open("GET", "./caracteristicas/votos/votar.php?voto="+valor+"&titulo_clave="+document.getElementById("titulo_clave").value);
        xmlhttp.send();
    }

    function mostrarPuntuacion(valor){
        
        let xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                if(this.responseText){
                    valor.innerHTML = this.responseText;
                } else{
                    valor.innerHTML = 0;
                }
                
            }
        };

        xmlhttp.open("GET", "./caracteristicas/votos/mostrar_puntuacion.php?mostrar="+valor.id+"&titulo_clave="+document.getElementById("titulo_clave").value);
        xmlhttp.send();
    }

    document.getElementById("like").addEventListener("click", event => {
       enviarVoto(event.target.id);
       mostrarPuntuacion(document.getElementById('contador_like'));
    });

    document.getElementById("dislike").addEventListener("click", event => {
        enviarVoto(event.target.id);
        mostrarPuntuacion(document.getElementById('contador_dislike'));
    });
</script>

<?php
include "./caracteristicas/utilidades/footer.php";