    // Access the user's webcam
    function getCameras() {
        navigator.mediaDevices.enumerateDevices()
        .then(function(devices) {
            const videoDevices = devices.filter(device => device.kind === 'videoinput');
            const cameraSelect = document.getElementById('camera-select');
            videoDevices.forEach((device, index) => {
                const option = document.createElement('option');
                option.value = device.deviceId;
                option.text = device.label || `Camera ${index + 1}`;
                cameraSelect.appendChild(option);
            });
    
            if (videoDevices.length > 0) {
                startCamera(videoDevices[0].deviceId); // Automatically start the first camera
                cameraSelect.selectedIndex = 0; // Set the dropdown to the first camera
            }
        })
        .catch(function(err) {
            console.error("An error occurred: " + err);
        });
    }

    function startCamera(deviceId) {
        navigator.mediaDevices.getUserMedia({ video: { deviceId: deviceId ? { exact: deviceId } : undefined } })
        .then(function(stream) {
            var video = document.getElementById('video');
            video.srcObject = stream;
            video.onloadedmetadata = function(e) {
                video.play();
            };
        })
        .catch(function(err) {
            console.error("An error occurred when accessing the camera: " + err);
        });
    }

    document.getElementById('camera-select').addEventListener('change', function() {
        startCamera(this.value);
    });

    getCameras();  // Get the list of cameras on load
    
// Capture the video frame
document.getElementById('capture').addEventListener('click', function() {
    var canvas = document.getElementById('canvas');
    var video = document.getElementById('video');
    canvas.getContext('2d').drawImage(video, 0, 0, 640, 480);
    canvas.style.display = 'block'; // Show the canvas
    document.getElementById('process').style.display = 'inline-block'; // Show the process button
});

// Process the captured image for validation
document.getElementById('process').addEventListener('click', function() {
    var canvas = document.getElementById('canvas');
    var imageData = canvas.toDataURL('image/jpg');
    console.log(imageData);
    sendImageDataToServer(imageData);
});

function sendImageDataToServer(imageData) {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch('/api/validate-face', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token  // Include CSRF token
        },
        body: JSON.stringify({ image: imageData })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Face validated successfully.');
            window.location.href = '/start-test/{{ $test->id }}'; // Redirect to the test
        } else {
            alert('Face validation failed. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while validating your face.');
    });
}