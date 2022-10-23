<?php

exec("mode COM3 BAUD=115200 PARITY=N data=8 stop=1 xon=off");

$conexaoArduino = fopen("COM3:", "w");

if(isset($_POST["btLiga"])){
	$btLiga = $_POST["btLiga"];

	if($btLiga == "0"){
		# DESLIGA LED SUITE
		fwrite($conexaoArduino, "0");
	} elseif ($btLiga == "1") {
		# LIGA LED SUITE
		fwrite($conexaoArduino, "1");
	} elseif ($btLiga == "2") {
		# DESLIGA LED SALA
		fwrite($conexaoArduino, "2");
	} elseif ($btLiga == "3") {
		# LIGA LED SALA
		fwrite($conexaoArduino, "3");
	} elseif ($btLiga == "4") {
		# DESLIGA LED CORREDOR
		fwrite($conexaoArduino, "4");
	} elseif ($btLiga == "5") {
		# LIGA LED CORREDOR
		fwrite($conexaoArduino, "5");
	} elseif ($btLiga == "6") {
		# DESLIGA LED QUARTO
		fwrite($conexaoArduino, "6");
	} elseif ($btLiga == "7") {
		# LIGA LED QUARTO
		fwrite($conexaoArduino, "7");
	}
	fclose($conexaoArduino);
	$response_array['POST'] = $_POST;
	$response_array['status'] = "success";
} else{
	$response_array['status'] = "erro";
}


header('Content-type: application/json');
echo json_encode($response_array);
