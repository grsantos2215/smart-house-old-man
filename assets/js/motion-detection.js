var $motionBox = $('.motion-box');

var scale = 10; // capture resolution over motion resolution
var isActivated = false;
var isTargetInSight = false;
var isKnockedOver = false;
var lostTimeout;

function initSuccess() {
    DiffCamEngine.start();
}

function initError() {
    alert('Something went wrong.');
}

function startComplete() {
    setTimeout(activate, 500);
}

function activate() {
    isActivated = true;
}

function capture(payload) {
    if (!isActivated || isKnockedOver) {
        return;
    }

    var box = payload.motionBox;
    if (box) {
        // video is flipped, so we're positioning from right instead of left
        var right = box.x.min * scale + 1;
        var top = box.y.min * scale + 1;
        var width = (box.x.max - box.x.min) * scale;
        var height = (box.y.max - box.y.min) * scale;

        $motionBox.css({
            display: 'block',
            right: right,
            top: top,
            width: width,
            height: height,
        });

        if (!isTargetInSight) {
            isTargetInSight = true;
        } else {
        }

        clearTimeout(lostTimeout);
        lostTimeout = setTimeout(declareLost, 5000);
    }

    // video is flipped, so (0, 0) is at top right
    if (payload.checkMotionPixel(0, 0)) {
        knockOver();
    }
}

function declareLost() {
    isTargetInSight = false;
    // PARTE MAIS IMPORTANTE
    $.ajax({
        url: 'assets/php/manipulate-components/manipula-buzzer.php',
        type: 'POST',
        data: {
            buzzer: '6',
        },
        success: function (data) {
            if (data.status == 'success') {
                console.log('certo');
            } else {
                console.log(data);
            }
        },
    });
}

function play(audioId) {
    $('#audio-' + audioId)[0].play();
}

DiffCamEngine.init({
    video: document.getElementById('video'),
    captureIntervalTime: 50,
    includeMotionBox: true,
    includeMotionPixels: true,
    initSuccessCallback: initSuccess,
    initErrorCallback: initError,
    startCompleteCallback: startComplete,
    captureCallback: capture,
});
