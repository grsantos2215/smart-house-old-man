<?php
// include 'class.interface-arduino.php';

// $comunicacao1 = new INTERFACEARDUINO;

$conexaoArduino = fopen("COM3", "w");

if (isset($_POST["btLiga"])) {
	fwrite($conexaoArduino, "1");
} else if (isset($_POST["btDesliga"])) {
	fwrite($conexaoArduino, "0");
}
fclose($conexaoArduino);
