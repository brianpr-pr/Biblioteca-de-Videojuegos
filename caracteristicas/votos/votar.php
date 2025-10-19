<?php
$voto = $_GET['voto'];
if($voto === 'like'){
    echo "<span style='color:green;'>Me gusta enviado correctamente.</span>";
} elseif($voto === 'dislike'){
    echo "<span style='color:green;'>No me gusta enviado correctamente.</span>";
} else{
    echo "<span style='color:red;'>Error en la votación.</span>";
}
