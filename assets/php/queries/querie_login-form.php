<?php

require_once("../connection.php");

if(!empty($_POST) && (empty($_POST['user']) || empty($_POST['senha']))){
	$response["status"] = "erro";
}

$user = mysqli_real_escape_string($conn, $_POST['user']);
$senha = mysqli_real_escape_string($conn, $_POST['senha']);

$sql_select_user = "SELECT id AS `id_usuario`, primeiro_nome AS `nome_usuario` FROM pessoa WHERE pessoa.primeiro_nome = '$user' AND '". sha1($senha) ."' AND status = 1";

$result = mysqli_query($conn, $sql_select_user);

if(mysqli_num_rows($result) != 1){
	$response["status"] = "erro";
	$response["sql"] = $sql_select_user;
} else {
	$row = mysqli_fetch_assoc($result);

	if(!isset($_SESSION)) session_start();

	$_SESSION["UsuarioID"] = $row['id_usuario'];
	$_SESSION["nomeUser"] = $row['nome_usuario'];

	$response['return']['url'] = "index.php";

	$response['return']['status'] = "success";
}

header('Content-type: application/json');
echo json_encode($response);