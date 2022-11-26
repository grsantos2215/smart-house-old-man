const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: 'btn m-1 btn-success',
        cancelButton: 'btn m-1 btn-danger',
    },
    buttonsStyling: false,
});

const cam = document.getElementById('cam');
let inputAcessos = document.getElementsByName('acessos[]');
let inputArquivos,
    arrArquivos,
    obj = [];
let arrAcessos = Array.from(inputAcessos);

navigator.getUserMedia(
    { video: true },
    function () {
        const startVideo = () => {
            navigator.mediaDevices.enumerateDevices().then((devices) => {
                if (Array.isArray(devices)) {
                    devices.forEach((device) => {
                        if (device.kind === 'videoinput') {
                            console.log(device);
                            navigator.getUserMedia(
                                {
                                    video: {
                                        deviceId: device.deviceId,
                                    },
                                },
                                (stream) => (cam.srcObject = stream),
                                (error) => console.error(error)
                            );
                        }
                    });
                }
            });
        };

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

        // prettier-ignore
        Promise.all([
            faceapi.nets.tinyFaceDetector.loadFromUri('assets/lib/face-api/models'), 
            faceapi.nets.faceLandmark68Net.loadFromUri('assets/lib/face-api/models'), 
            faceapi.nets.faceRecognitionNet.loadFromUri('assets/lib/face-api/models'), 
            faceapi.nets.faceExpressionNet.loadFromUri('assets/lib/face-api/models'), 
            faceapi.nets.ageGenderNet.loadFromUri('assets/lib/face-api/models'), 
            faceapi.nets.ssdMobilenetv1.loadFromUri('assets/lib/face-api/models')
        ]).then(startVideo);

        cam.addEventListener('play', async () => {
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

                    $.ajax({
                        url: 'assets/php/queries/querie_login.php',
                        type: 'POST',
                        data: {
                            user: label.toLowerCase(),
                        },
                        success: function (data) {
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
                        },
                    });
                });
            }, 10);
        });
    },
    function () {
        // webcam is not available
        swalWithBootstrapButtons
            .fire({
                title: 'Atenção',
                text: 'Não foi encontrado nenhuma Webcam em seu computador por conta disso, será alterada a forma de login',
                icon: 'warning',
                allowOutsideClick: false,
                allowEscapeKey: false,
            })
            .then(() => {
                $('#teste').remove();
                $('.display-mobile').attr('style', 'display: block;');
            });
    }
);
