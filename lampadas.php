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
					<div class="col-md-4 my-2 col-sm-12">
						<div class="border d-flex flex-column justify-content-between h-100 p-3 rounded-2 w-100">
							<div class="d-flex my-2 align-items-center justify-content-between">
								<h5 class="fw-bold">Sala de estar</h5>
								<div>
									<i class="fa-regular fa-lightbulb text-danger fa-2x" id="lampada_sala"></i>
								</div>
							</div>
							<form id="submit-led-sala">
								<div class="d-grid gap-2 mt-3">
									<input type="hidden" value="1" name="btLiga" id="btLiga-sala">
									<button type="submit" class="btn btn-primary d-block" id="btn_submit-sala">Acender</button>
								</div>
							</form>
						</div>
					</div>
					<div class="col-md-4 my-2 col-sm-12">
						<div class="border d-flex flex-column justify-content-between h-100 p-3 rounded-2 w-100">
							<div class="d-flex my-2 align-items-center justify-content-between">
								<h5 class="fw-bold">Banheiro</h5>
								<div>
									<i class="fa-regular fa-lightbulb text-danger fa-2x" id="lampada_banheiro"></i>
								</div>
							</div>
							<form id="submit-led-banheiro">
								<div class="d-grid gap-2 mt-3">
									<input type="hidden" value="1" name="btLiga" id="btLiga-banheiro">
									<button type="submit" class="btn btn-primary d-block" id="btn_submit-banheiro">Acender</button>
								</div>
							</form>
						</div>
					</div>
					<div class="col-md-4 my-2 col-sm-12">
						<div class="border d-flex flex-column justify-content-between h-100 p-3 rounded-2 w-100">
							<div class="d-flex my-2 align-items-center justify-content-between">
								<h5 class="fw-bold">Quarto</h5>
								<div>
									<i class="fa-regular fa-lightbulb text-danger fa-2x" id="lampada_quarto"></i>
								</div>
							</div>
							<form id="submit-led-quarto">
								<div class="d-grid gap-2 mt-3">
									<input type="hidden" value="1" name="btLiga" id="btLiga-quarto">
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
			if (localStorage.getItem("ledQuarto") == "1") {
				$("#lampada_quarto").removeClass("fa-regular text-danger");
				$("#lampada_quarto").addClass("fa-solid text-success");
				$("#btLiga-quarto").attr("value", "1");
				$("#btn_submit-quarto").html("Apagar");
			} else {
				$("#btLiga-quarto").attr("value", "0");
				$("#lampada_quarto").removeClass("fa-solid text-success");
				$("#lampada_quarto").addClass("fa-regular text-danger");
				$("#btn_submit-quarto").html("Acender");
			}
		})

		$("#submit-led-quarto").on("submit", (e) => {
			e.preventDefault();
			console.log($("#btn_submit-quarto"));
			$.ajax({
				url: "assets/php/manipulate-components/manipula-ino-quarto.php",
				type: "POST",
				data: $("#submit-led-quarto").serialize(),
				success: function(data) {
					console.log(data);
					if (data.status == "success") {
						if (data.POST.btLiga == "1") {
							$("#btLiga-quarto").attr("value", "0");
							localStorage.setItem("ledQuarto", 0);
							$("#lampada_quarto").removeClass("fa-solid text-success");
							$("#lampada_quarto").addClass("fa-regular text-danger");
							$("#btn_submit-quarto").html("Acender");
						} else {
							$("#btLiga-quarto").attr("value", "1");
							localStorage.setItem("ledQuarto", 1);
							$("#lampada_quarto").removeClass("fa-regular text-danger");
							$("#lampada_quarto").addClass("fa-solid text-success");
							$("#btn_submit-quarto").html("Apagar");
						}

					}
				}
			})
		})
	</script>
</body>

</html>