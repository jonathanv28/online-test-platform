document.addEventListener('DOMContentLoaded', function() {
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
                startCamera(videoDevices[0].deviceId);
                cameraSelect.selectedIndex = 0;
            }
        })
        .catch(function(err) {
            console.error("An error occurred: " + err);
        });
    }

    function startCamera(deviceId) {
        navigator.mediaDevices.getUserMedia({ video: { deviceId: deviceId ? { exact: deviceId } : undefined, aspectRatio: 1.777 } }) // Aspect ratio for 16:9
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

    getCameras();

    document.getElementById('capture-and-validate').addEventListener('click', function() {
        var button = this;
        var canvas = document.getElementById('canvas');
        var video = document.getElementById('video');
        var startTestButton = document.getElementById('start-test');

        // Set the button to loading state
        button.innerHTML = '<svg aria-hidden="true" role="status" class="inline mr-2 w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"></svg> Validating ...';
        button.disabled = true;
        button.classList.replace('bg-blue-700', 'bg-blue-900');

        canvas.getContext('2d').drawImage(video, 0, 0, 854, 480);
        video.style.display = 'none';
        canvas.style.display = 'block';

        var imageData = canvas.toDataURL('image/jpg');
        sendImageDataToServer(imageData);

        function sendImageDataToServer(imageData) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const testId = document.getElementById('testId').value;

            fetch('/api/validate-face', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({ image: imageData, test_id: testId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    startTestButton.classList.replace('bg-gray-300', 'bg-blue-700');
                    startTestButton.disabled = false;
                    startTestButton.classList.remove('cursor-not-allowed', 'text-gray-700');
                    startTestButton.classList.add('cursor-pointer', 'hover:bg-blue-900', 'focus:ring-4', 'focus:ring-blue-200', 'text-white');

                    document.getElementById('validation-success-message').textContent = 'Face validated successfully! You may proceed to start the test by clicking the "Start Test" button.';
                    document.getElementById('alertSuccess').classList.remove('hidden');

                    button.innerHTML = 'Capture & Validate';
                    button.classList.remove('text-white', 'bg-blue-700', 'focus:outline-none', 'hover:bg-blue-900', 'focus:ring-4', 'focus:ring-blue-200');
                    button.classList.add('cursor-not-allowed', 'text-gray-700', 'bg-gray-300');
                    button.disabled = true;
                } else {
                    button.classList.replace('bg-blue-900', 'bg-blue-700');
                    document.getElementById('alertError').classList.remove('fade-out');
                    document.getElementById('validation-error-message').textContent = data.validationError || 'Face validation failed. Please try again.';
                    document.getElementById('alertError').classList.remove('hidden');
                    
                    const alert = document.getElementById('alertError');
                    setTimeout(() => {
                        alert.classList.add('fade-out');
                    }, 5000);

                    setTimeout(() => {
                        alert.classList.add('hidden');
                    }, 6000);

                    video.style.display = 'block';
                    canvas.style.display = 'none';
                    
                    button.innerHTML = 'Capture & Validate';
                    button.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert(error.message);
                button.innerHTML = 'Capture & Validate';
                button.disabled = false;
            });
        }
    });

    const testId = document.getElementById('testId').value;
    document.getElementById('start-test').addEventListener('click', function() {
        fetch('/tests/' + testId + '/start', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ test_id: testId })
        }).then(()=> {
            window.location.href = '/tests/' + testId + '/1';
        }).catch(error => {
            console.error('Error starting test:', error);
        });
        
    });
});
