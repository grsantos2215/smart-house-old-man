<?php

exec("mode COM3 BAUD=115200 PARITY=N data=8 stop=1 xon=off");

$conexaoArduino = fopen("COM3:", "w");

if(isset($_POST["destrava"])){
	$destrava = $_POST["destrava"];

	if($destrava == "8"){
		# ABRE PORTA
		fwrite($conexaoArduino, "8");
	} elseif($destrava == "9"){
		# FECHA PORTA
		fwrite($conexaoArduino, "9");
	}

	fclose($conexaoArduino);
	$response_array['POST'] = $_POST;
	$response_array['status'] = "success";
} else{
	$response_array['status'] = "erro";
}

header('Content-type: application/json');
echo json_encode($response_array);