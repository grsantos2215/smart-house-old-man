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
	<title>Dispositivos</title>
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
								<h5 class="m-0 p-0 fw-bold">Dispositivos</h5>
							</div>
							<div class="d-flex justify-content-end align-items-center">
								<button href="#" class="btn btn-success btn-lg" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Adicionar</button>
								
							</div>
						</div>
					</div>
				</div>
				<div class="row my-2">
					<?php while($row = mysqli_fetch_array($result_select_componentes)){ ?>
						<div class="col-md-3 col-sm-6 my-2" id="<?= $row['id'] ?>">
							<div class="border d-flex flex-column align-items-center justify-content-center h-100 p-3 rounded-2 w-100">
								<h5 class="fw-bold m-0 p-0"><?= $row['nomeComponente'] ?></h5>
								<div class="d-grid gap-2 w-100 mt-2">
									<button type="button" data-componente-id="<?= $row['id'] ?>" class="remove-componente btn btn-outline-danger mt-3">Remover</button>
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

	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="exampleModalLabel">Adicionar novo Dispositivo</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form id="adiciona-dispositivo">
						<input class="form-control" type="text" name="nome_dispositivo" id="nome_dispositivo" placeholder="Nome do Dispositivo">
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

			$("#adiciona-dispositivo").on("submit", (e) => {
				e.preventDefault();
				$.ajax({
					url: "assets/php/queries/querie_adiciona_dispositivo.php",
					type: "POST",
					data: $("#adiciona-dispositivo").serialize(),
					success: function(data) {
						console.log(data);
						if(data.status == "success"){
							swalWithBootstrapButtons.fire({
								title: 'Sucesso',
								text: 'Dispositivo adicionado com sucesso',
								icon: 'success',
								allowOutsideClick: false,
								allowEscapeKey: false,
							}).then(() => {
								location.reload();
							})
						} else {
							swalWithBootstrapButtons
                            .fire({
                                title: 'Ops... Ocorreu um erro',
                                text: 'Infelizmente não foi possível inserir um novo dispositivo. Por favor, tente novamente',
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

			$(".remove-componente").click((e) => {
				e.preventDefault();
				let idComponente = $(e.target).attr("data-componente-id");
				// console.log(idComponente)
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
					if(r.isConfirmed){
						$.ajax({
							url: "assets/php/queries/querie_remove_componente.php",
							type: "POST",
							data: {
								"componente_id": idComponente
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
									$(`#${idComponente}`).remove()
								})
							}
						})
					}
				})
			})
		})
	</script>
</body>

</html>