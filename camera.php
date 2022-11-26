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
	<!-- <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@1.2"></script>
	<script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/body-pix@2.0"></script> -->
	<!-- <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"> </script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/mobilenet"> </script> -->
</head>

<body>
	<?php for ($i = 0; $i < count($arquivos); $i++) { ?>
		<?php if((count($arquivos[$i]['arquivos']) < 0) || (count($arquivos[$i]['arquivos']) == NULL)){ ?>
			<?php break; ?>
		<?php } ?>
		<input type="hidden" name="acessos[]" value="<?= $arquivos[$i]['nome'] ?>">
		<?php for ($j = 0; $j < count($arquivos[$i]['arquivos']); $j++) { ?>
			<input type="hidden" name="arquivos[<?= $arquivos[$i]['nome'] ?>]" value="<?= $arquivos[$i]['arquivos'][$j] ?>">
		<?php } ?>
	<?php } ?>
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
							<!-- <video id="video" autoplay></video> -->
							<img id="cam" crossorigin src="http://192.168.43.91:81/stream"> 
							<!-- <canvas id="canvas"></canvas> -->
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
	<!-- <script src="assets/js/cam.js"></script> -->
	<!-- <script src="https://webrtc.github.io/adapter/adapter-1.0.7.js"></script> -->
	<!-- <script src="assets/js/diff-cam-engine.js"></script> -->
	<!-- <script src="assets/js/motion-detection.js"></script> -->
	<!-- END IMPORT JS LIBRARIES -->
	
	<script>
		$(async function() {
			const cam = document.getElementById('cam');
			let inputAcessos = document.getElementsByName('acessos[]');
			let inputArquivos,
				arrArquivos,
				obj = [];
			let arrAcessos = Array.from(inputAcessos);
			Promise.all([
				faceapi.nets.tinyFaceDetector.loadFromUri('assets/lib/face-api/models'),
				faceapi.nets.faceLandmark68Net.loadFromUri('assets/lib/face-api/models'),
				faceapi.nets.faceRecognitionNet.loadFromUri('assets/lib/face-api/models'),
				faceapi.nets.faceExpressionNet.loadFromUri('assets/lib/face-api/models'),
				faceapi.nets.ageGenderNet.loadFromUri('assets/lib/face-api/models'),
				faceapi.nets.ssdMobilenetv1.loadFromUri('assets/lib/face-api/models')
			]).then(async () => {
				const canvas = faceapi.createCanvasFromMedia(cam);
				const canvasSize = {
					width: cam.width,
					height: cam.height,
				};
				const labels = await loadLabels();
				
				faceapi.matchDimensions(canvas, canvasSize);
            	document.querySelector('#teste').appendChild(canvas);

				setInterval(async () => {
					const detections = await faceapi.detectAllFaces(cam, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptors();
					const resizedDetections = faceapi.resizeResults(detections, canvasSize);
					const faceMatcher = new faceapi.FaceMatcher(labels, 0.6);
					const results = resizedDetections.map((d) => faceMatcher.findBestMatch(d.descriptor));
					canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
					faceapi.draw.drawDetections(canvas, resizedDetections);
					faceapi.draw.drawFaceLandmarks(canvas, resizedDetections);
					results.forEach((result, index) => {
						const box = resizedDetections[index].detection.box;
						const { label, distance } = result;
						new faceapi.draw.DrawTextField([`${label} (${parseInt(distance * 100, 10)})`], box.bottomRight).draw(canvas);

						if(label != "unknown"){
							$.ajax({
								url: "assets/php/manipulate-components/manipula-porta.php",
								type: "POST",
								data: {
									destrava: "8",
								},
								success: function(data) {
									if(data.status == "success"){
										console.log("certo");
									} else {
										console.log(data);
									}
								}
							})
						}
					});
				}, 10);
			})

			
			
			const loadLabels = () => {
				const labels = [];
				for (let i = 0; i < arrAcessos.length; i++) {
					labels.push(arrAcessos[i].value);
				}
				console.log(labels);
				
				return Promise.all(
					labels.map(async (label) => {
						inputArquivos = document.getElementsByName(`arquivos[${label}]`);
						arrArquivos = Array.from(inputArquivos);
						const descriptions = [];
						for (let i = 0; i < arrArquivos.length; i++) {
							obj[i] = arrArquivos[i].value;
							if (obj[i]) {
								const img = await faceapi.fetchImage(`assets/lib/face-api/labels/${label}/${obj[i]}`);
								const detections = await faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor();
								descriptions.push(detections.descriptor);
							} else {
								throw new Error('erro');
							}
						}
						return new faceapi.LabeledFaceDescriptors(label, descriptions);
					})
				);
			};
			
			
			
		})

		
		// const img = document.getElementById('video');
		// const canvas = document.getElementById("canvas");
		// const ctx = canvas.getContext('2d');
		// img.crossorigin = ' ';
		// const opacity = 0.7;
		// const flipHorizontal = false;
		// const maskBlurAmount = 0;

		// window.addEventListener("load", async () => {
		// 	const network = await bodyPix.load({
		// 		architecture: 'MobileNetV1',
		// 		outputStride: 16,
		// 		multiplier: 0.75,
		// 		quantBytes: 2
		// 	});

		// 	setInterval(async () => {
		// 		const segmentation = await network.segmentMultiPersonParts(img);
		// 		const mask = bodyPix.toColoredPartMask(segmentation);
		// 		console.log(mask);
		// 		bodyPix.drawMask(canvas, img, mask, opacity, maskBlurAmount, flipHorizontal);
		// 	}, 100);
		// })
	</script>
</body>

</html>