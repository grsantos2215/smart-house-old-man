<?php

// $chave = "65aa04c149239ba218bbf8101d83a80f";
// $location = "São Paulo";

// $arrContextOptions = array(
// 	"ssl" => array(
// 		"verify_peer" => false,
// 		"verify_peer_name" => false,
// 	),
// );

// // $json_file = file_get_contents("http://api.weatherstack.com/current?access_key=$chave&query=$location", false, stream_context_create($arrContextOptions));
// $json_file = file_get_contents("/smart-house-old-man/assets/js/current.json");
// echo var_dump($json_file);
// $response = $json_file;

// echo $response;


$location = 'São Paulo';

$queryString = http_build_query([
	'access_key' => '65aa04c149239ba218bbf8101d83a80f',
	'query' => $location,
]);

$ch = curl_init(sprintf('%s?%s', 'http://api.weatherstack.com/current', $queryString));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$json = curl_exec($ch);
curl_close($ch);

$api_result = json_decode($json, true);

echo $json;
