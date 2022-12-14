<?php

require_once("connection.php");

if ($_POST) {
	$nomePessoaPost = $_POST["nome_pessoa"];
	$nomePessoa = str_replace(" ", "_", tirarAcentos($nomePessoaPost));
	// echo $nomePessoa;

	$nomePessoa_banco = strtolower($nomePessoa);

	$tipo_conexao = $_SERVER['HTTP_HOST'];

	if ($tipo_conexao == "localhost" || $tipo_conexao == "127.0.0.1") {
		$ds = "";
		$pastaLocal = "../lib/face-api/labels/$nomePessoa/";
	}

	if (!is_dir($pastaLocal)) {

		$oldmask = umask(000); //it will set the new umask and returns the old one 
		mkdir($pastaLocal);
		umask($oldmask); //reset the old umask
	}

	$sql_insert = "INSERT INTO pessoa(primeiro_nome) VALUES ('$nomePessoa_banco')";
	$result_insert = mysqli_query($conn, $sql_insert);
	mysqli_close($conn);
}

function tirarAcentos($string)
{
	return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $string);
}
