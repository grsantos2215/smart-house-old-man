<?php
require_once("assets/php/functions.php");

$dir = base64_decode($_GET["p"]);

?>



<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Gerenciamento - <?= $dir ?></title>
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
								<h5 class="m-0 p-0 fw-bold"><?= $dir; ?></h5>
							</div>
							<div class="d-flex justify-content-end align-items-center">
								<a href="gerenciamento.php" class="btn btn-outline-light me-2">Voltar para a página anterior</a>
								<button class="btn btn-success btn-lg" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Adicionar Foto</button>
							</div>
						</div>
					</div>
				</div>
				<div class="row my-2">
					<?php
					$dirName = scandir("assets/lib/face-api/labels/$dir");
					$diretorio = "assets/lib/face-api/labels/$dir";
					for ($i = 2; $i < count($dirName); $i++) {
					?>

						<div class="col-md-3 col-sm-6 my-2">
							<div class="border d-flex flex-column align-items-center justify-content-center h-100 p-3 rounded-2 w-100">
								<img src="<?= $diretorio . '/' . $dirName[$i] ?>" class="img-fluid">
								<form class="remove-photo w-100">
									<input type="hidden" name="foto-diretorio" value="<?= $dir . '/' . $dirName[$i] ?>">
									<div class="d-grid gap-0 w-100 mt-3">
										<button type="submit" class="btn btn-outline-danger">Remover foto</button>
									</div>
								</form>
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
					<h1 class="modal-title fs-5" id="exampleModalLabel">Adicionar nova Foto</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form id="adiciona-foto" enctype="multipart/form-data">
						<input type="hidden" name="pessoa" value="<?= $dir ?>">
						<input type="hidden" name="quantidadeAtual" value="<?= count($dirName) - 2 ?>">
						<input class="form-control" id="adicionaFotoArquivos" name="adicionaFotoArquivos[]" type="file" accept="image/*" multiple>
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

			$("#adiciona-foto").on("change", (e) => {
				var formData = new FormData($("#adiciona-foto")[0]);
				$.ajax({
					url: "assets/php/adiciona-foto.php",
					type: "POST",
					data: formData,
					processData: false,
					contentType: false,
					success: function(data) {
						swalWithBootstrapButtons.fire({
							title: 'Sucesso',
							text: 'Foto adicionada com sucesso',
							icon: 'success',
							allowOutsideClick: false,
							allowEscapeKey: false,
						}).then(() => {
							location.reload();
						})
					}
				})
			})

			$(".remove-photo").on("submit", (e) => {
				e.preventDefault();

				swalWithBootstrapButtons.fire({
					title: "Tem Certeza?",
					icon: "warning",
					text: "Tem certeza que deseja excluir esta foto? Essa ação não terá recuperação",
					allowOutsideClick: false,
					allowEscapeKey: false,
					showCancelButton: true,
					reverseButtons: true,
					confirmButtonText: 'Sim, Quero excluir',
					cancelButtonText: 'Cancelar',
				}).then((r) => {

					if (r.isConfirmed) {
						$.ajax({
							url: "assets/php/remove-foto.php",
							type: "POST",
							data: $(".remove-photo").serialize(),
							success: function(data) {

								swalWithBootstrapButtons.fire({
									title: 'Sucesso',
									text: 'Foto removida com sucesso',
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
							text: 'A foto permanece em segurança',
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