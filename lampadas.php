<?php require_once("assets/php/functions.php") ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Lâmpadas</title>
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
				<div class="row my-2">
					<div class="col-md-6 my-2 col-sm-12">
						<div class="border d-flex flex-column justify-content-between h-100 p-3 rounded-2 w-100">
							<div class="d-flex my-2 align-items-center justify-content-between">
								<h5 class="fw-bold">Sala de estar</h5>
								<div>
									<i class="fa-regular fa-lightbulb text-danger fa-2x" id="lampada_sala"></i>
								</div>
							</div>
							<form id="submit-led-sala">
								<div class="d-grid gap-2 mt-3">
									<input type="hidden" value="3" name="btLiga" id="btLiga-sala">
									<button type="submit" class="btn btn-primary d-block" id="btn_submit-sala">Acender</button>
								</div>
							</form>
						</div>
					</div>
					<div class="col-md-6 my-2 col-sm-12">
						<div class="border d-flex flex-column justify-content-between h-100 p-3 rounded-2 w-100">
							<div class="d-flex my-2 align-items-center justify-content-between">
								<h5 class="fw-bold">Corredor</h5>
								<div>
									<i class="fa-regular fa-lightbulb text-danger fa-2x" id="lampada_corredor"></i>
								</div>
							</div>
							<form id="submit-led-corredor">
								<div class="d-grid gap-2 mt-3">
									<input type="hidden" value="5" name="btLiga" id="btLiga-corredor">
									<button type="submit" class="btn btn-primary d-block" id="btn_submit-corredor">Acender</button>
								</div>
							</form>
						</div>
					</div>
					<div class="col-md-6 my-2 col-sm-12">
						<div class="border d-flex flex-column justify-content-between h-100 p-3 rounded-2 w-100">
							<div class="d-flex my-2 align-items-center justify-content-between">
								<h5 class="fw-bold">Suite</h5>
								<div>
									<i class="fa-regular fa-lightbulb text-danger fa-2x" id="lampada_suite"></i>
								</div>
							</div>
							<form id="submit-led-suite">
								<div class="d-grid gap-2 mt-3">
									<input type="hidden" value="1" name="btLiga" id="btLiga-suite">
									<button type="submit" class="btn btn-primary d-block" id="btn_submit-suite">Acender</button>
								</div>
							</form>
						</div>
					</div>
					<div class="col-md-6 my-2 col-sm-12">
						<div class="border d-flex flex-column justify-content-between h-100 p-3 rounded-2 w-100">
							<div class="d-flex my-2 align-items-center justify-content-between">
								<h5 class="fw-bold">Quarto</h5>
								<div>
									<i class="fa-regular fa-lightbulb text-danger fa-2x" id="lampada_quarto"></i>
								</div>
							</div>
							<form id="submit-led-quarto">
								<div class="d-grid gap-2 mt-3">
									<input type="hidden" value="7" name="btLiga" id="btLiga-quarto">
									<button type="submit" class="btn btn-primary d-block" id="btn_submit-quarto">Acender</button>
								</div>
							</form>
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
		$(function() {
			if (localStorage.getItem("ledSuite") == "0") {
				$("#btLiga-suite").attr("value", "0");
				$("#lampada_suite").removeClass("fa-regular text-danger");
				$("#lampada_suite").addClass("fa-solid text-success");
				$("#btn_submit-suite").html("Apagar");
			} else if(localStorage.getItem("ledSuite") == "1") {
				$("#btLiga-suite").attr("value", "1");
				$("#lampada_suite").removeClass("fa-solid text-success");
				$("#lampada_suite").addClass("fa-regular text-danger");
				$("#btn_submit-suite").html("Acender");
			}

			if (localStorage.getItem("ledSala") == "3") {
				$("#btLiga-sala").attr("value", "3");
				$("#lampada_sala").removeClass("fa-solid text-success");
				$("#lampada_sala").addClass("fa-regular text-danger");
				$("#btn_submit-suite").html("Acender");
			} else if(localStorage.getItem("ledSala") == "2") {
				$("#btLiga-sala").attr("value", "2");
				$("#lampada_sala").removeClass("fa-regular text-danger");
				$("#lampada_sala").addClass("fa-solid text-success");
				$("#btn_submit-suite").html("Apagar");
			}

			if (localStorage.getItem("ledCorredor") == "5") {
				$("#btLiga-corredor").attr("value", "5");
				$("#lampada_corredor").removeClass("fa-solid text-success");
				$("#lampada_corredor").addClass("fa-regular text-danger");
				$("#btn_submit-corredor").html("Acender");
			} else if(localStorage.getItem("ledCorredor") == "4") {
				$("#btLiga-corredor").attr("value", "4");
				$("#lampada_corredor").removeClass("fa-regular text-danger");
				$("#lampada_corredor").addClass("fa-solid text-success");
				$("#btn_submit-corredor").html("Apagar");
			}
			
			if (localStorage.getItem("ledQuarto") == "7") {
				$("#btLiga-quarto").attr("value", "7");
				$("#lampada_quarto").removeClass("fa-solid text-success");
				$("#lampada_quarto").addClass("fa-regular text-danger");
				$("#btn_submit-quarto").html("Acender");
			} else if(localStorage.getItem("ledQuarto") == "6") {
				$("#btLiga-quarto").attr("value", "6");
				$("#lampada_quarto").removeClass("fa-regular text-danger");
				$("#lampada_quarto").addClass("fa-solid text-success");
				$("#btn_submit-quarto").html("Apagar");
			}
		})

		$("#submit-led-sala").on("submit", (e) => {
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
							$("#lampada_sala").removeClass("fa-regular text-danger");
							$("#lampada_sala").addClass("fa-solid text-success");
							$("#btn_submit-suite").html("Apagar");
						} else {
							$("#btLiga-sala").attr("value", "3");
							localStorage.setItem("ledSala", 3);
							$("#lampada_sala").removeClass("fa-solid text-success");
							$("#lampada_sala").addClass("fa-regular text-danger");
							$("#btn_submit-suite").html("Acender");
						}

					}
				}
			})
		})
		
		$("#submit-led-corredor").on("submit", (e) => {
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
							$("#lampada_corredor").removeClass("fa-regular text-danger");
							$("#lampada_corredor").addClass("fa-solid text-success");
							$("#btn_submit-corredor").html("Apagar");
						} else {
							$("#btLiga-corredor").attr("value", "5");
							localStorage.setItem("ledCorredor", 5);
							$("#lampada_corredor").removeClass("fa-solid text-success");
							$("#lampada_corredor").addClass("fa-regular text-danger");
							$("#btn_submit-corredor").html("Acender");
						}

					}
				}
			})
		})

		$("#submit-led-suite").on("submit", (e) => {
			e.preventDefault();
			console.log($("#submit-led-suite").serialize());
			$.ajax({
				url: "assets/php/manipulate-components/manipula-ino.php",
				type: "POST",
				data: $("#submit-led-suite").serialize(),
				success: function(data) {
					console.log(data);
					if (data.status == "success") {
						if (data.POST.btLiga == "1") {
							$("#btLiga-suite").attr("value", "0");
							localStorage.setItem("ledSuite", 0);
							$("#lampada_suite").removeClass("fa-regular text-danger");
							$("#lampada_suite").addClass("fa-solid text-success");
							$("#btn_submit-suite").html("Apagar");
						} else {
							$("#btLiga-suite").attr("value", "1");
							localStorage.setItem("ledSuite", 1);
							$("#lampada_suite").removeClass("fa-solid text-success");
							$("#lampada_suite").addClass("fa-regular text-danger");
							$("#btn_submit-suite").html("Acender");
						}
					}
				}
			})
		})
		
		$("#submit-led-quarto").on("submit", (e) => {
			e.preventDefault();
			console.log($("#submit-led-quarto").serialize());
			$.ajax({
				url: "assets/php/manipulate-components/manipula-ino.php",
				type: "POST",
				data: $("#submit-led-quarto").serialize(),
				success: function(data) {
					console.log(data);
					if (data.status == "success") {
						if (data.POST.btLiga == "7") {
							$("#btLiga-quarto").attr("value", "6");
							localStorage.setItem("ledQuarto", 6);
							$("#lampada_quarto").removeClass("fa-regular text-danger");
							$("#lampada_quarto").addClass("fa-solid text-success");
							$("#btn_submit-quarto").html("Apagar");
						} else {
							$("#btLiga-quarto").attr("value", "7");
							localStorage.setItem("ledQuarto", 7);
							$("#lampada_quarto").removeClass("fa-solid text-success");
							$("#lampada_quarto").addClass("fa-regular text-danger");
							$("#btn_submit-quarto").html("Acender");
						}
					}
				}
			})
		})
	</script>
</body>

</html>