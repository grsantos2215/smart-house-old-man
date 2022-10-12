<?php

// exec("mode COM3 BAUD=115200 PARITY=N data=8 stop=1 xon=off");

// $conexaoArduino = fopen("COM3:", "w");

// if (isset($_POST["btLiga"])) {
// 	fwrite($conexaoArduino, "1");
// } else if (isset($_POST["btDesliga"])) {
// 	fwrite($conexaoArduino, "0");
// }
// fclose($conexaoArduino);


$response_array['POST'] = $_POST;
$response_array['status'] = "success";

header('Content-type: application/json');
echo json_encode($response_array);
