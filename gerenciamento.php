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

?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Gerenciamento</title>
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
						<div class="border p-3 rounded-2 w-100 d-flex justify-content-between align-items-center">
							<div>
								<h5 class="m-0 p-0 fw-bold">Pessoas</h5>
							</div>
							<div class="d-flex justify-content-end align-items-center">
								<button class="btn btn-success btn-lg" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Adicionar</button>
							</div>
						</div>
					</div>
				</div>
				<div class="row my-2">
					<?php
					$dir = scandir('assets/lib/face-api/labels/');
					for ($i = 2; $i < count($dir); $i++) {
					?>

						<div class="col-md-3 col-sm-6 my-2">
							<div class="border d-flex flex-column align-items-center justify-content-center h-100 p-3 rounded-2 w-100">
								<h5 class="fw-bold m-0 p-0"><?= $dir[$i]; ?></h5>
								<div class="d-grid gap-2 w-100 mt-3">
									<a class="btn btn-primary" href="adiciona-fotos.php?p=<?= base64_encode($dir[$i]) ?>">Visualizar</a>
									<form class="remove-pessoa">
										<div class="d-grid gap-0 w-100 mt-3">
											<button type="submit" data-value="../lib/face-api/labels/<?= $dir[$i] ?>/" class="remove-diretorio btn btn-outline-danger">Excluir acesso</button>
										</div>
									</form>
								</div>
							</div>
						</div>

					<?php } ?>

				</div>
			</div>
		</div>
	</main>
	<!-- END MAIN CONTENT -->

	<!-- IMPORT JS LIBRARIES -->
	<?php require_once("components/imports.php"); ?>
	<!-- END IMPORT JS LIBRARIES -->
	<!-- MODAL -->
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="exampleModalLabel">Adicionar nova Pessoa</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form id="adiciona-pessoa">
						<input class="form-control" type="text" name="nome_pessoa" id="nome_pessoa" placeholder="Nome da Pessoa">
						<div class="d-grid gap-2 mt-3">
							<button type="submit" class="btn btn-success mt-1">Adicionar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(function() {
			const swalWithBootstrapButtons = Swal.mixin({
				customClass: {
					confirmButton: 'btn m-1 btn-success',
					cancelButton: 'btn m-1 btn-danger'
				},
				buttonsStyling: false
			})

			$("#adiciona-pessoa").on("submit", (e) => {
				e.preventDefault();
				$.ajax({
					url: "assets/php/adiciona-pessoa.php",
					type: "POST",
					data: $("#adiciona-pessoa").serialize(),
					success: function(data) {
						swalWithBootstrapButtons.fire({
							title: 'Sucesso',
							text: 'Acesso adicionada com sucesso',
							icon: 'success',
							allowOutsideClick: false,
							allowEscapeKey: false,
						}).then(() => {
							location.reload();
						})
					}
				})
			})

			$(".remove-diretorio").click((e) => {
				e.preventDefault();
				let diretorio = $(e.target).attr("data-value")
				swalWithBootstrapButtons.fire({
					title: "Tem Certeza?",
					icon: "warning",
					text: "Tem certeza que deseja excluir este acesso? Essa ação não terá recuperação",
					allowOutsideClick: false,
					allowEscapeKey: false,
					showCancelButton: true,
					reverseButtons: true,
					confirmButtonText: 'Sim, Quero excluir',
					cancelButtonText: 'Cancelar',
				}).then((r) => {
					if (r.isConfirmed) {
						
						$.ajax({
							url: "assets/php/remove-pessoa.php",
							type: "POST",
							data: {
								diretorio: diretorio
							},
							success: function(data) {
								console.log(data);
								swalWithBootstrapButtons.fire({
									title: 'Sucesso',
									text: 'Acesso removido com sucesso',
									icon: 'success',
									allowOutsideClick: false,
									allowEscapeKey: false,
								}).then(() => {
									location.reload();
								})
							}
						})
					} else {
						swalWithBootstrapButtons.fire({
							title: 'Cancelado',
							text: 'O acesso permanece no sistema',
							icon: 'error',
							allowOutsideClick: false,
							allowEscapeKey: false,
						})
					}
				})
			})
		});
	</script>
</body>

</html>