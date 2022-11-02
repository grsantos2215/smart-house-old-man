<?php

if (!empty($_FILES)) {
	$pessoa = $_POST['pessoa'];
	$quantidadeAtual = $_POST['quantidadeAtual'] + 1;
	$files = array_filter($_FILES['adicionaFotoArquivos']['name']); //Use something similar before processing files.


	$total_count = count($_FILES['adicionaFotoArquivos']['name']);

	for ($i = 0; $i < $total_count; $i++) {
		//The temp file path is obtained
		$tmpFilePath = $_FILES['adicionaFotoArquivos']['tmp_name'][$i];
		//A file path needs to be present
		$extension  = pathinfo($_FILES["adicionaFotoArquivos"]["name"][$i], PATHINFO_EXTENSION); // jpg
		$basename   = $quantidadeAtual . "." . $extension; // 5dab1961e93a7_1571494241.jpg


		if ($tmpFilePath != "") {
			//Setup our new file path
			$newFilePath = "../lib/face-api/labels/$pessoa/" . $basename;
			//File is uploaded to temp dir
			if (move_uploaded_file($tmpFilePath, $newFilePath)) {
				//Other code goes here
			}
		}
	}
	echo "assets/lib/face-api/labels/$pessoa/" . $basename;
}
