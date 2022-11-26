<?php

require_once("../connection.php");

$select_api_clima = "SELECT api.chave as `chave` FROM api WHERE api.nome_api = 'clima' AND api.status = 1";

$result = mysqli_query($conn, $select_api_clima);


if($result){
	$row_clima = mysqli_fetch_array($result);

	$chave = $row_clima["chave"];

	$arrContextOptions = array(
		"ssl" => array(
			"verify_peer" => false,
			"verify_peer_name" => false,
		),
	);

	$json_fileGeoIP = file_get_contents("https://api.hgbrasil.com/geoip?key=$chave&address=remote", false, stream_context_create($arrContextOptions));

	$json_decode = json_decode($json_fileGeoIP);

	$latitude = $json_decode->results->latitude;
	$longitude = $json_decode->results->longitude;


	$json_file = file_get_contents("https://api.hgbrasil.com/weather?key=$chave&lat=$latitude&lon=$longitude", false, stream_context_create($arrContextOptions));

	$response = $json_file;

	echo $response;
}
