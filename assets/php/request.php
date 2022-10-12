<?php

$arrContextOptions = array(
	"ssl" => array(
		"verify_peer" => false,
		"verify_peer_name" => false,
	),
);

// $json_file = file_get_contents("http://api.weatherstack.com/current?access_key=$chave&query=$location", false, stream_context_create($arrContextOptions));
$json_file = file_get_contents("https://api.hgbrasil.com/weather?woeid=452815", false, stream_context_create($arrContextOptions));
// echo var_dump($json_file);
$response = $json_file;

echo $response;
