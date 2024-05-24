document.addEventListener('DOMContentLoaded', function() {
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

    getCameras(); // Get the list of cameras on load

    document.getElementById('capture-and-validate').addEventListener('click', function() {
        var button = this;
        var canvas = document.getElementById('canvas');
        var video = document.getElementById('video');
        var startTestButton = document.getElementById('start-test');

        // Set the button to loading state
        button.innerHTML = '<svg aria-hidden="true" role="status" class="inline mr-2 w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"></svg> Loading ...';
        button.disabled = true; // Disable the button to prevent multiple clicks

        canvas.getContext('2d').drawImage(video, 0, 0, 854, 480); // Draw the video frame to the canvas
        video.style.display = 'none'; // Hide the video
        canvas.style.display = 'block'; // Show the canvas with the captured image

        var imageData = canvas.toDataURL('image/jpg'); // Convert canvas to image data
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
                    alert('Face validated successfully.');
                    startTestButton.classList.replace('bg-gray-300', 'bg-blue-700'); // Change Start Test button color to active
                    startTestButton.disabled = false; // Enable the Start Test button
                    startTestButton.classList.remove('cursor-not-allowed', 'text-gray-700');
                    startTestButton.classList.add('cursor-pointer', 'hover:bg-blue-900', 'focus:ring-4', 'focus:ring-green-200', 'text-white'); // Enable and stylize the button

                    button.innerHTML = 'Capture & Validate'; // Reset the button text
                    button.classList.remove('text-white', 'bg-blue-700', 'focus:outline-none', 'hover:bg-blue-900', 'focus:ring-4', 'focus:ring-green-200'); // Enable and stylize the button
                    button.classList.add('cursor-not-allowed', 'text-gray-700', 'bg-gray-300'); // Enable and stylize the button
                    button.disabled = true; // Re-enable the button
                } else {
                    alert('Face validation failed. Please try again.');
                    video.style.display = 'block'; // Show the video again
                    canvas.style.display = 'none'; // Hide the canvas
                    
                    button.innerHTML = 'Capture & Validate'; // Reset the button text
                    button.disabled = false; // Re-enable the button
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert(error.message);
                button.innerHTML = 'Capture & Validate'; // Reset the button text
                button.disabled = false; // Re-enable the button
            });
        }
    });

    const testId = document.getElementById('testId').value;
    document.getElementById('start-test').addEventListener('click', function() {
        window.location.href = '/tests/' + testId + '/1';
    });
});
