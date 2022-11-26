<?php


$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "smarthouse";/**/


$conn = mysqli_connect($servidor, $usuario, $senha, $banco);
mysqli_set_charset( $conn, 'utf8');
// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
