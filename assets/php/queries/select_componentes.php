<?php

$sql_select_componentes = "SELECT componentes.id as `id`, componentes.nome as `nomeComponente`, componentes.quantidade as `quantidade` FROM componentes WHERE componentes.status = 1";

// $result_select_componentes = mysqli_query($conn, $sql_select_componentes);

// if($result_select_componentes){
// 	$i = 0;
// 	while($row_select_componentes = mysqli_fetch_array($result_select_componentes)){
// 		$response["id"][$i] = $row_select_componentes["id"];
// 		$response["nomeComponente"][$i] = $row_select_componentes["nomeComponente"];
// 		$response["quantidade"][$i] = $row_select_componentes["quantidade"];
// 		$i++;
// 	}

// 	$response["status"] = 'success';
// }

// mysqli_close($conn);