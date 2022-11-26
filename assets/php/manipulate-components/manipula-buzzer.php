<?php

exec("mode COM3 BAUD=9600 PARITY=N data=8 stop=1 xon=off");

$conexaoArduino = fopen("COM3:", "w");

if(isset($_POST["buzzer"])){
	$buzzer = $_POST["buzzer"];

	if($buzzer){
		# LIGA BUZZER
		fwrite($conexaoArduino, "6");
	}

	fclose($conexaoArduino);
	$response_array['POST'] = $_POST;
	$response_array['status'] = "success";
} else{
	$response_array['status'] = "erro";
}

header('Content-type: application/json');
echo json_encode($response_array);