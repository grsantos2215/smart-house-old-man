<?php
require_once("assets/php/functions.php");


$diretorios = scandir('assets/lib/face-api/labels/');
$acessos;
$arquivos;

for ($i = 2; $i < count($diretorios); $i++) {
	$acessos[] = $diretorios[$i];
}

for ($i = 0; $i < count($acessos); $i++) {
	$dir = 'assets/lib/face-api/labels/' . $acessos[$i] . '/';
	$fotos = scandir($dir);

	$arquivos[$i]['nome'] = $acessos[$i];
	for ($j = 2; $j < count($fotos); $j++) {
		$arquivos[$i]['arquivos'][] = $fotos[$j];
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Câmera</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Karla:wght@300;400;500;700&family=Rubik:wght@400;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/style.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/1413796360.js" crossorigin="anonymous"></script>
	<!-- <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@1.2"></script> -->
	<!-- <script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/body-pix@2.0"></script> -->
</head>

<body>
	<?php for ($i = 0; $i < count($arquivos); $i++) { ?>
		<input type="hidden" name="acessos[]" value="<?= $arquivos[$i]['nome'] ?>">
		<?php for ($j = 0; $j < count($arquivos[$i]['arquivos']); $j++) { ?>
			<input type="hidden" name="arquivos[<?= $arquivos[$i]['nome'] ?>]" value="<?= $arquivos[$i]['arquivos'][$j] ?>">
		<?php } ?>
	<?php } ?>


	<!-- IMPORT SIDE MENU -->
	<?php require_once("components/sidemenu.php"); ?>
	<!-- END IMPORT SIDE MENU -->

	<!-- MAIN CONTENT -->
	<main>
		<div class="container-fluid">
			<?php require_once("components/navbar.php") ?>
			<div class="py-5" id="content">
				<div class="row my-2 justify-content-center">
					<div class="col-md-8">
						<div class="border d-flex flex-column justify-content-center align-items-center h-100 p-3 rounded-2 w-100" id="teste">
							<video autoplay id="cam" width="720" height="560" muted></video>

						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
	<!-- END MAIN CONTENT -->

	<!-- IMPORT JS LIBRARIES -->

	<?php require_once("components/imports.php"); ?>
	<script src="assets/js/cam.js"></script>
	<!-- END IMPORT JS LIBRARIES -->
</body>

</html>