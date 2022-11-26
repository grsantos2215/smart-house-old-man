<?php

require_once("../connection.php");

if($_POST){
	$nome_componente = $_POST["nome_dispositivo"];

	$sql_insert = "INSERT INTO componentes(nome) VALUES ('$nome_componente')";
	$result_insert = mysqli_query($conn, $sql_insert);

	if ($result_insert) {
        $response_array['status'] = "success";
    } else {
        $response_array['status'] = $sql_insert;
    }
	mysqli_close($conn);
} else {
    $response_array['status'] = "erro2";
}

header('Content-type: application/json');
echo json_encode($response_array);