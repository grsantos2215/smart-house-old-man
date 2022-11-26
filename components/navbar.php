<div class="row">
	<div class="col-md-6">
		<div class="row">
			<div class="col-3 d-flex align-items-center justify-content-center">
				<i class="fa-solid fa-user fa-3x"></i>
			</div>
			<div class="col-9 m-auto">
				<h5 class="fw-bold text-capitalize" id="nome">Olá, <?= $_SESSION['nomeUser'] ?></h5>
				<p class="m-0 p-0">Seja bem vindo</p>
			</div>
		</div>
	</div>

	<div class="col-md-6 m-auto text-end d-md-block d-none">
		<p class="p-0 m-0 fw-bold"><?php echo $date ?></p>
		<p class="p-0 m-0"><?php echo $day ?></p>
	</div>
</div>