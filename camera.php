<?php require_once("assets/php/functions.php") ?>

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
	<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@1.2"></script>
	<script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/body-pix@2.0"></script>
	<!-- <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"> </script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/mobilenet"> </script> -->
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
				<div class="row my-2 justify-content-center">
					<div class="col-md-8">
						<div class="border d-flex flex-column justify-content-center align-items-center h-100 p-3 rounded-2 w-100" id="teste">
							<!-- <video autoplay id="cam" width="720" height="560" muted></video> -->

							<img id="video" crossorigin src="http://192.168.15.54:81/stream">
							<canvas id="canvas"></canvas>
							<div id="results"></div>
							<a href="#" class="btn" onclick="classifyImg()">Classify the image</a>
							<!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/__MOMa3Z9Kk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
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
		const img = document.getElementById('video');
		const canvas = document.getElementById("canvas");
		const ctx = canvas.getContext('2d');
		img.crossorigin = ' ';
		const opacity = 0.7;
		const flipHorizontal = false;
		const maskBlurAmount = 0;

		window.addEventListener("load", async () => {
			const network = await bodyPix.load({
				architecture: 'MobileNetV1',
				outputStride: 16,
				multiplier: 0.75,
				quantBytes: 2
			});

			setInterval(async () => {
				const segmentation = await network.segmentMultiPersonParts(img);
				const mask = bodyPix.toColoredPartMask(segmentation);
				bodyPix.drawMask(canvas, img, mask, opacity, maskBlurAmount, flipHorizontal);
			}, 100);
		})
	</script>
</body>

</html>