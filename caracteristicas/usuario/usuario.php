<?php
function salirUsuario(){
    $_SESSION['nombre_usuario'] = null;
    $_SESSION['email_usuario'] = null;
    header("");
}