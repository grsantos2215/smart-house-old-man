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

<body class="vh-100">
	<?php for ($i = 0; $i < count($arquivos); $i++) { ?>
		<input type="hidden" name="acessos[]" value="<?= $arquivos[$i]['nome'] ?>">
		<?php for ($j = 0; $j < count($arquivos[$i]['arquivos']); $j++) { ?>
			<input type="hidden" name="arquivos[<?= $arquivos[$i]['nome'] ?>]" value="<?= $arquivos[$i]['arquivos'][$j] ?>">
		<?php } ?>
	<?php } ?>

	<!-- MAIN CONTENT -->
		<main class="h-100 m-0 d-flex align-items-center justify-content-center">
			<div class="container m-0 h-100">

				<div class="row h-100">

					<div class="col-md-12 p-0 m-0 d-flex justify-content-end flex-column text-center">
						<h5 class="text-center fw-bold">Login</h5>
						<span class="text-center text-secondary">Para utilizar o sistema, será necessário a utilização da câmera do seu computador ou, caso esteja no celular, saber seu login e senha</span>
					</div>
					<div class="col-md-12 p-0 d-flex justify-content-center mt-4 display-desktop" id="teste">
						<video autoplay id="cam" width="665" height="500" muted></video>
					</div>
					
					<div class="col-md-12 p-0 mt-4 display-mobile">
						<div class="row d-flex justify-content-center align-items-center h-100">
							<div class="col-12 col-md-8 col-lg-6 col-xl-5">
								<div class="card bg-transparent" style="border-radius: 1rem;">
									<div class="card-body p-5 text-center">
										<div class="mb-md-5 mt-md-4 pb-5">
											<p class="text-white-50 mb-5">Por favor, entre com o seu usuário e senha</p>
											<form id="login_form">
												<div class="form-outline text-start mb-4">
													<label class="form-label" for="user">Usuário <sub class="text-secondary">(primeiro nome)</sub></label>
													<input type="text" id="user" name="user" class="form-control form-control-lg" />
												</div>
												<div class="form-outline text-start mb-4">
													<label class="form-label" for="senha">Senha</label>
													<input type="password" id="senha" name="senha" class="form-control form-control-lg" />
												</div>
												<button class="btn btn-primary btn-lg px-5" type="submit">Entrar</button>
											</form>
										</div>
										<div>

										</div>

									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-12 p-0 m-0 d-flex align-items-end text-center">
						<span class="logo bg-transparent">Houseguard<sup class="m-0 p-0"><i class="fa-solid fa-key"></i></sup></span>
					</div>
				</div>
			</div>
		</main>
	<!-- END MAIN CONTENT -->

	<!-- IMPORT JS LIBRARIES -->

	<?php require_once("components/imports.php"); ?>
	<script src="assets/js/cam.js"></script>
	<!-- END IMPORT JS LIBRARIES -->

	<script>
		$(function() {
			$("#login_form").on("submit", (e) => {
				e.preventDefault();
				$.ajax({
					url: "assets/php/queries/querie_login-form.php",
					type: "POST",
					data: $("#login_form").serialize(),
					success: function(data){
						console.log(data);
						if (data.return.status == 'success') {
							window.location.href = data.return.url;
						} else {
							swalWithBootstrapButtons
								.fire({
									title: 'Ops... Ocorreu um erro',
									text: 'Infelizmente não foi possível realizar o login. Por favor, tente novamente',
									icon: 'warning',
									allowOutsideClick: false,
									allowEscapeKey: false,
								})
								.then(() => {
									location.reload();
								});
						}
					}
				})
			})
		})
	</script>
</body>

</html>