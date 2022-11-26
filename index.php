<?php
// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) session_start();
// Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION['UsuarioID'])) {
	// Destrói a sessão por segurança
	session_destroy();
	// Redireciona o visitante de volta pro login
	header("Location: login.php");
	exit;
}

require_once("assets/php/functions.php");
require_once("assets/php/connection.php");
require_once("assets/php/queries/select_componentes.php");

$result_select_componentes = mysqli_query($conn, $sql_select_componentes);

?>

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
					<div class="col-md-6 my-2" id="card-clima">
						<div class="border p-3 rounded-2 w-100">
							<div class="d-flex justify-content-center">
								<div class="spinner-grow" role="status">
									<span class="visually-hidden">Loading...</span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6 my-2" id="card-clima-forecast">
						<div class="border p-3 rounded-2 w-100">
							<div class="d-flex justify-content-center">
								<div class="spinner-grow" role="status">
									<span class="visually-hidden">Loading...</span>
								</div>
							</div>
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
									<form id="submit-led-sala">
										<label class="custom-control teleport-switch">
											<input type="hidden" value="3" name="btLiga" id="btLiga-sala">
											<input type="checkbox" class="teleport-switch-control-input" name="btn_submit-sala" id="btn_submit-sala">
											<span class="teleport-switch-control-indicator"></span>
										</label>
									</form>
								</div>
							</div>
							<div class="d-flex my-2 justify-content-between">
								<p class="m-0">Corredor</p>
								<div>
									<form id="submit-led-corredor">
										<label class="custom-control teleport-switch">
											<input type="hidden" value="5" name="btLiga" id="btLiga-corredor">
											<input type="checkbox" class="teleport-switch-control-input" name="btn_submit-corredor" id="btn_submit-corredor">
											<span class="teleport-switch-control-indicator"></span>
										</label>
									</form>
								</div>
							</div>
							<div class="mt-3">
								<a href="lampadas.php" class="btn btn-primary d-block">Ver todos</a>
							</div>
						</div>
					</div>
					<div class="col-md-8 my-2 col-sm-12">
						<div class="border d-flex flex-column justify-content-between h-100 p-3 rounded-2 w-100">
							<h5 class="fw-bold">Acessos ao sistema</h5>
							<div class="d-flex my-2 justify-content-between">
								<p class="m-0">Permitidos</p>
								<div>
									<p class="m-0 ">
										<?php
										$dir = scandir('assets/lib/face-api/labels/');
										for ($i = 2; $i < count($dir); $i++) {
										?>
											<span><?= $dir[$i]; ?></span><span class="virgula">,</span>
										<?php } ?>
									</p>
								</div>
							</div>
							<div class="d-grid gap-2 mt-3">
								<a href="gerenciamento.php" class="btn btn-primary d-block">Gerenciar</a>
							</div>
						</div>
					</div>
					<!-- <div class="col-md-4 my-2 col-sm-12">
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
							<form id="controla-porta">
								<input type="hidden" value="8" name="destrava" id="door-control">
								<div class="d-grid gap-2 mt-3">
									<button type="submit" class="btn btn-primary d-block">Destrancar</button>
								</div>
							</form>
						</div>
					</div> -->
				</div>

				<div class="row my-2">
					<!-- <div class="col-md-4 my-2 col-sm-12">
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
					</div> -->
					<div class="col-md-8 my-2 col-sm-12">
						<div class="border h-100 p-3 rounded-2 w-100">
							<h5 class="fw-bold">Câmeras</h5>
							<div class="d-flex my-2 align-items-center justify-content-between">
								<p class="m-0">Sala</p>
								<div>
									<a href="camera.php" class="btn btn-primary">Visualizar</a>
								</div>
							</div>
							<div class="d-flex my-2 align-items-center justify-content-between">
								<p class="m-0">Térmica</p>
								<div>
									<a href="termica.php" class="btn btn-primary">Visualizar</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4 my-2 col-sm-12">
						<div class="border d-flex flex-column justify-content-between p-3 h-100 rounded-2 w-100">
							<h5 class="fw-bold">Dispositivos</h5>
							<div class="d-flex my-2 justify-content-between">
								<div>
									<p class="m-0 ">
										<?php 
										$contador = 0;
										while($row = mysqli_fetch_array($result_select_componentes)){ 
										?>
											<span><?= $row['nomeComponente'] ?></span><span class="virgula">,</span>
										<?php 
										$contador++;

										if($contador == 3){
											echo '<span class="etc">...</span>';
											break;
										}
										} 
										?>
									</p>
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

	<script>
		let allWeathers = [];
		let icons;
		let divWeather = null;
		let divWeatherForecast = null;
		window.addEventListener("load", async () => {
			divWeather = document.querySelector("#card-clima");
			divWeatherForecast = document.querySelector("#card-clima-forecast");
			await fetchWeathers();
		});


		const fetchWeathers = async () => {
			const request = new Request("assets/php/api/clima.php");
			const req = await fetch(request);
			const json = await req.json();

			allWeathers = json.results;
			render();
		}

		const render = () => {
			if (allWeathers.condition_slug == 'rain' && allWeathers.currently == 'noite') {
				icon = 'fa-cloud-moon-rain';
			} else if (allWeathers.condition_slug == 'rain' && allWeathers.currently == 'dia'){
				icon = 'fa-cloud-sun-rain';
			} else if ((allWeathers.condition_slug == 'fog' || allWeathers.condition_slug == 'cloudly_night') && allWeathers.currently == 'noite') {
				icon = 'fa-cloud-moon';
			} else if ((allWeathers.condition_slug == 'fog' || allWeathers.condition_slug == 'cloudly_day') && allWeathers.currently == 'dia') {
				icon = 'fa-cloud-sun';
			} else if (allWeathers.condition_slug == 'cloud') {
				icon = 'fa-cloud';
			} else if (allWeathers.condition_slug == 'storm') {
				icon = 'fa-cloud-bolt';
			} else if ((allWeathers.condition_slug == 'clear_day') && allWeathers.currently == 'dia') {
				icon = 'fa-sun';
			} else if ((allWeathers.condition_slug == 'clear_day') && allWeathers.currently == 'noite') {
				icon = 'fa-moon';
			} else {
				icon = 'fa-cloud';
			}

			renderClima();
			renderForecast();
		}

		const renderClima = () => {
			console.log(allWeathers);

			const weathersHTML = `
			<div class="border p-3 rounded-2 w-100">
				<div class="row py-4 ps-3">
					<div class="col-md-4 d-flex justify-content-center">
						<i class="fa-solid ${icon} fa-8x"></i>
					</div>
					<div class="col-md-8 d-flex flex-column justify-content-evenly">
						<div class="row align-items-center">
							<div class="col-md-8">
								<h5 class="fw-bold text-center">${allWeathers.description}</h5>
							</div>
							<div class="col-md-4 m-0 p-0">
								<h2 class="fw-bold text-center">${allWeathers.temp}°C</h2>
							</div>
						</div>
						<div class="row align-items-center">
							<div class="col-md-8">
								<h6 class="fw-bold text-secondary text-center">Umidade do Ar</h6>
							</div>
							<div class="col-md-4 m-0 p-0">
								<h5 class="fw-bold text-secondary text-center">${allWeathers.humidity}%</h5>
							</div>
						</div>

					</div>
				</div>
			</div>`;

			divWeather.innerHTML = weathersHTML;

		}

		const renderForecast = () => {
			let forecastItems = allWeathers.forecast;
			// let contador = 1;

			let forecastsHTML = `
			<div class="border p-3 h-100 pb-0 ps-0 pe-0 rounded-2 w-100">
				<div class="row m-0 h-100">
			`

			forecastItems.every((forecast) => {
				const { min, max, condition, date, weekday } = forecast

				if (condition == 'rain') {
					icon = 'fa-cloud-rain';
				} else if (condition == 'rain'){
					icon = 'fa-cloud-sun-rain';
				} else if (condition == 'cloud') {
					icon = 'fa-cloud';
				} else if (condition == 'storm') {
					icon = 'fa-cloud-bolt';
				} else if (condition == 'clear_day') {
					icon = 'fa-sun';
				} else {
					icon = 'fa-cloud';
				}

				const forecastHTML = `
					<div class="col-md-4 d-inline-block border-end forecast" style="--bs-border-opacity: .5;">
						<h5 class="fw-bold text-center">${weekday}</h5>
						<h6 class="fw-bold text-secondary text-center">${date}</h6>
						<i class="fa-solid text-center w-100 ${icon} fa-2x"></i>
						<h5 class="fw-bold text-center">${max}°</h5>
						<h6 class="fw-bold text-secondary text-center">${min}°</h6>
					</div>
				`

				forecastsHTML += forecastHTML;

				return true
			})
			forecastsHTML += `
				</div>
			</div>
			`

			divWeatherForecast.innerHTML = forecastsHTML;

		}

		$(function(){

			if (localStorage.getItem("ledSala") == "3") {
				$("#btLiga-sala").attr("value", "3");
				$("#btn_submit-sala").removeAttr("checked");
			} else if(localStorage.getItem("ledSala") == "2") {
				$("#btLiga-sala").attr("value", "2");
				$("#btn_submit-sala").attr("checked", "true");
			}

			if (localStorage.getItem("ledCorredor") == "5") {
				$("#btLiga-corredor").attr("value", "5");
				$("#btn_submit-corredor").removeAttr("checked");
			} else if(localStorage.getItem("ledCorredor") == "4") {
				$("#btLiga-corredor").attr("value", "4");
				$("#btn_submit-corredor").attr("checked", "true");
			}
			

			$("#controla-porta").on("submit", (e) =>{
				e.preventDefault();

				$.ajax({
					url: "assets/php/manipulate-components/manipula-porta.php",
					type: "POST",
					data: $("#controla-porta").serialize(),
					success: function(data){
						console.log(data);

						if (data.POST.destrava == "8") {
							$("#door-control").attr("value", "9");
						} else {
							$("#door-control").attr("value", "8");
						}
					}
				})
			})
		})

		$("#submit-led-sala").on("change", (e) => {
			e.preventDefault();
			$.ajax({
				url: "assets/php/manipulate-components/manipula-ino.php",
				type: "POST",
				data: $("#submit-led-sala").serialize(),
				success: function(data) {
					console.log(data);
					if(data.status == "success"){
						if (data.POST.btLiga == "3") {
							$("#btLiga-sala").attr("value", "2");
							localStorage.setItem("ledSala", 2);
							$("#btn_submit-sala").attr("checked", "true");
						} else {
							$("#btLiga-sala").attr("value", "3");
							localStorage.setItem("ledSala", 3);
							$("#btn_submit-sala").removeAttr("checked");
						}
					}
				}
			})
		})

		$("#submit-led-corredor").on("change", (e) => {
			e.preventDefault();
			$.ajax({
				url: "assets/php/manipulate-components/manipula-ino.php",
				type: "POST",
				data: $("#submit-led-corredor").serialize(),
				success: function(data) {
					console.log(data);
					if(data.status == "success"){
						if (data.POST.btLiga == "5") {
							$("#btLiga-corredor").attr("value", "4");
							localStorage.setItem("ledCorredor", 4);
							$("#btn_submit-corredor").attr("checked", "true");
						} else {
							$("#btLiga-corredor").attr("value", "5");
							localStorage.setItem("ledCorredor", 5);
							$("#btn_submit-corredor").attr("checked", "false");
						}

					}
				}
			})
		})
	</script>
</body>

</html>