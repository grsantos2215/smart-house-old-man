<?php
// include 'class.interface-arduino.php';

// $comunicacao1 = new INTERFACEARDUINO;

exec("mode COM3 BAUD=115200 PARITY=N data=8 stop=1 xon=off");

$conexaoArduino = fopen("COM3:", "w");

if (isset($_POST["btLiga"])) {
	fwrite($conexaoArduino, "1");
} else if (isset($_POST["btDesliga"])) {
	fwrite($conexaoArduino, "0");
}
fclose($conexaoArduino);