<?php require_once("assets/php/functions.php") ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Karla:wght@300;400;500;700&family=Rubik:wght@400;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/style.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/1413796360.js" crossorigin="anonymous"></script>

</head>

<body>
	<!-- IMPORT SIDE MENU -->
	<?php require_once("components/sidemenu.php"); ?>
	<!-- END IMPORT SIDE MENU -->

	<!-- MAIN CONTENT -->
	<main>
		<div class="container-fluid">
			<?php require_once("components/navbar.php") ?>
			<div class="py-5" id="content">
				<div class="row mb-4">
					<div class="col-md-12">
						<div class="border p-3 rounded-2 w-100">
							<h5 class="card-title">Temperatura</h5>
							<p class="card-text">{JSON.results.temp}ºC</p>
						</div>
					</div>
				</div>

				<div class="row my-2">
					<div class="col-md-4 my-2 col-sm-12">
						<div class="border h-100 p-3 rounded-2 w-100">
							<h5 class="fw-bold">Luzes</h5>
							<div class="d-flex my-2 justify-content-between">
								<p class="m-0">Sala de Estar</p>
								<div>
									<label class="custom-control teleport-switch">
										<input type="checkbox" class="teleport-switch-control-input" name="sala" id="sala">
										<span class="teleport-switch-control-indicator"></span>
									</label>
								</div>
							</div>
							<div class="d-flex my-2 justify-content-between">
								<p class="m-0">Banheiro</p>
								<div>
									<label class="custom-control teleport-switch">
										<input type="checkbox" class="teleport-switch-control-input" name="banheiro" id="banheiro">
										<span class="teleport-switch-control-indicator"></span>
									</label>
								</div>
							</div>
							<div class="mt-3">
								<a href="lampadas.php" class="btn btn-primary d-block">Ver todos</a>
							</div>
						</div>
					</div>
					<div class="col-md-4 my-2 col-sm-12">
						<div class="border d-flex flex-column justify-content-between h-100 p-3 rounded-2 w-100">
							<h5 class="fw-bold">Wi-Fi: LOREM IPSUM</h5>
							<div class="d-flex my-2 justify-content-between">
								<p class="m-0">Download</p>
								<div>
									<p class="m-0 text-success">299.85 <span class="fw-bold">Mbps</span></p>
								</div>
							</div>
							<div class="d-flex my-2 justify-content-between">
								<p class="m-0">Upload</p>
								<div>
									<p class="m-0 text-success">299.85 <span class="fw-bold">Mbps</span></p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4 my-2 col-sm-12">
						<div class="border d-flex flex-column justify-content-between h-100 p-3 rounded-2 w-100">
							<h5 class="fw-bold">Porta</h5>
							<div class="d-flex my-2 align-items-center justify-content-between">
								<p class="m-0">Trancada</p>
								<div>
									<i class="fa-solid fa-door-closed text-success fa-2x "></i>
								</div>
							</div>
							<div class="d-flex my-2 align-items-center justify-content-between d-none">
								<p class="m-0">Destrancada</p>
								<div>
									<i class="fa-solid fa-door-open text-danger fa-2x"></i>
								</div>
							</div>
							<div class="d-grid gap-2 mt-3">
								<button type="button" class="btn btn-primary d-block">Destrancar</button>
							</div>
						</div>
					</div>
				</div>

				<div class="row my-2">
					<div class="col-md-4 my-2 col-sm-12">
						<div class="border h-100 p-3 rounded-2 w-100">
							<h5 class="fw-bold">Temperatura Corporal</h5>
							<div class="d-flex my-2 justify-content-between">
								<p class="m-0">Temperatura</p>
								<div>
									<p class="m-0 text-success">30°</p>
								</div>
							</div>
							<div class="d-flex my-2 justify-content-between">
								<p class="m-0">Status</p>
								<div>
									<p class="m-0 text-warning">Abaixo</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4 my-2 col-sm-12">
						<div class="border h-100 p-3 rounded-2 w-100">
							<h5 class="fw-bold">Câmeras</h5>
							<div class="d-flex my-2 align-items-center justify-content-between">
								<p class="m-0">Quarto</p>
								<div>
									<a href="camera.php" class="btn btn-primary">Visualizar</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4 my-2 col-sm-12">
						<div class="border p-3 rounded-2 w-100">
							<h5 class="fw-bold">Dispositivos</h5>
							<div class="d-flex my-2 align-items-center justify-content-between">
								<p class="m-0">Sensor</p>
								<div>
									<i class="fa-sharp fa-regular fa-lightbulb text-danger fa-2x"></i>
								</div>
							</div>
							<div class="d-flex my-2 align-items-center justify-content-between">
								<p class="m-0">Câmera</p>
								<div>
									<i class="fa-sharp fa-regular fa-lightbulb text-danger fa-2x"></i>
								</div>
							</div>
							<div class="mt-3">
								<a href="dispositivos.php" class="btn btn-primary d-block">Ver todos</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
	<!-- END MAIN CONTENT -->

	<!-- IMPORT JS LIBRARIES -->
	<?php require_once("components/imports.php"); ?>
	<!-- END IMPORT JS LIBRARIES -->
</body>

</html>