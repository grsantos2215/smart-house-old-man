<?php

if ($_POST) {
	$imagem = "../lib/face-api/labels/" . $_POST['foto-diretorio'];

	// echo $imagem;

	echo var_dump(unlink($imagem));
}
