<?php
session_start();
error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', 1);
$titulo = $_GET["titulo"];
if($titulo){
    echo $titulo;
}