<?php

require_once("../connection.php");

if($_POST){
	$idComponente = $_POST['componente_id'];

	$sql_update = "UPDATE componentes SET componentes.status = 0 WHERE componentes.id = $idComponente";
	$result_update = mysqli_query($conn, $sql_update);

	if ($result_update) {
        $response_array['status'] = "success";
    } else {
        $response_array['status'] = $sql_update;
    }

	mysqli_close($conn);
} else {
    $response_array['status'] = "erro2";
}

header('Content-type: application/json');
echo json_encode($response_array);