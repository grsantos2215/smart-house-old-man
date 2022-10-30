<?php

if ($_POST) {
	$diretorio = $_POST['diretorio'];
	echo $diretorio;

	if (!is_dir($diretorio)) {
		throw new InvalidArgumentException("$diretorio must be a directory");
	}
	if (substr($diretorio, strlen($diretorio) - 1, 1) != '/') {
		$diretorio .= '/';
	}

	$files = glob($diretorio . '*', GLOB_MARK);
	foreach ($files as $file) {
		if (is_dir($file)) {
			self::deleteDir($file);
		} else {
			unlink($file);
		}
	}
	rmdir($diretorio);
	// if (rmdir($diretorio)) {
	// 	echo 'sucesso';
	// } else {
	// 	echo var_dump(rmdir($diretorio));
	// }
}
