document.addEventListener('DOMContentLoaded', function() {
    const questions = document.querySelectorAll('.question');
    let currentQuestionIndex = 0;
    const monitorIntervalTime = 2000; //  monitoring
    const logsCheckIntervalTime = 1000; // checking logs
    let suspiciousActivityInterval;
    let lastLogTimestamp = null; // To track the last log's timestamp

    function showQuestion(index) {
        questions.forEach((question, idx) => {
            question.style.display = idx === index ? 'block' : 'none';
        });
        currentQuestionIndex = index;
        updateNavigationButtons();
        updateQuestionNav();
        updateQuestionNumber();
    }

    function navigateQuestion(step) {
        currentQuestionIndex += step;
        currentQuestionIndex = Math.max(0, Math.min(currentQuestionIndex, questions.length - 1));
        showQuestion(currentQuestionIndex);
    }

    function updateNavigationButtons() {
        document.getElementById('previous').style.display = currentQuestionIndex > 0 ? 'inline-block' : 'none';
        document.getElementById('next').style.display = currentQuestionIndex < questions.length - 1 ? 'inline-block' : 'none';
        document.getElementById('submit-test').style.display = currentQuestionIndex === questions.length - 1 ? 'block' : 'none';
        document.getElementById('submit-test-dupe').style.display = currentQuestionIndex === questions.length - 1 ? 'inline-block' : 'none';
    }

    function updateQuestionNav() {
        document.querySelectorAll('.question-nav-btn').forEach((btn, idx) => {
            btn.style.backgroundColor = idx === currentQuestionIndex ? 'aliceblue' : '';
        });
    }

    function updateQuestionNumber() {
        const questionNumberElement = document.getElementById('question-number');
        questionNumberElement.textContent = `Question ${currentQuestionIndex + 1}`;
    }

    function startTimer(duration, startTime) {
        const timerElement = document.getElementById('timer');
        const interval = setInterval(() => {
            const now = new Date();
            const elapsed = Math.floor((now - startTime) / 1000);
            const remaining = duration - elapsed;
            // console.log(`Elapsed: ${elapsed} seconds, Remaining: ${remaining} seconds`);
            if (remaining <= 0) {
                clearInterval(interval);
                submitTest();
                localStorage.removeItem('test_start_time');
            } else {
                const minutes = Math.floor(remaining / 60);
                const seconds = remaining % 60;
                timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }
        }, 1000);
    }

    function initializeTimer() {
        const testId = document.getElementById('testId').value;
        fetch(`/test-start-time/${testId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.start_time) {
                const startTime = new Date(data.start_time);
                // console.log(`Start Time from server: ${startTime}`);
                const testDuration = parseInt(document.querySelector('.test-container').dataset.duration, 10) * 60;
                startTimer(testDuration, startTime);
            } else {
                alert('Failed to retrieve start time.');
            }
        })
        .catch(error => console.error('Error retrieving start time:', error));
    }

    // function addBeforeUnloadListener() {
    //     window.addEventListener('beforeunload', function (e) {
    //         const confirmationMessage = 'Are you sure you want to leave? Your test progress will be lost.';
    //         (e || window.event).returnValue = confirmationMessage;
    //         return confirmationMessage;
    //     });
    // }
    
    // function removeBeforeUnloadListener() {
    //     window.removeEventListener('beforeunload', function (e) {
    //         const confirmationMessage = 'Are you sure you want to leave? Your test progress will be lost.';
    //         (e || window.event).returnValue = confirmationMessage;
    //         return confirmationMessage;
    //     });
    // }

    document.getElementById('next').addEventListener('click', () => navigateQuestion(1));
    document.getElementById('previous').addEventListener('click', () => navigateQuestion(-1));

    showQuestion(0);
    updateNavigationButtons();
    // addBeforeUnloadListener();

    document.querySelectorAll('.question-nav-btn').forEach((btn, index) => {
        btn.addEventListener('click', () => showQuestion(index));
    });

    document.querySelectorAll('input[type="radio"]').forEach((input) => {
        input.addEventListener('change', () => {
            const questionIndex = Array.from(questions).indexOf(input.closest('.question'));
            const navBtn = document.querySelector(`.question-nav-btn[data-question-index="${questionIndex}"]`);
            if (navBtn) {
                navBtn.classList.add('border-t-4');
                navBtn.classList.add('border-green-400');
            }
        });
    });

    document.getElementById('submit-test').addEventListener('click', function(event) {
        event.preventDefault();
        submitTest();
    });

    function submitTest() {
        const submitButton = document.getElementById('submit-test');
        const closeButton = document.getElementById('popup-modal-close');
        submitButton.innerHTML = '<svg aria-hidden="true" role="status" class="inline mr-2 w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"></svg> Submitting Test ...';
        submitButton.classList.replace('bg-blue-600', 'bg-blue-800');
        closeButton.classList.remove('hover:bg-gray-200');
        closeButton.classList.remove('hover:text-gray-900');
        submitButton.disabled = true;
        closeButton.disabled = true;

        const answers = {};
        document.querySelectorAll('.question').forEach(question => {
            const questionId = question.dataset.questionId;
            const selectedAnswer = question.querySelector('input[type="radio"]:checked');
            if (selectedAnswer) {
                answers[questionId] = selectedAnswer.value;
            }
        });

        fetch('/tests/' + document.getElementById('testId').value + '/submit', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({answers})
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if(data.success) {
                // removeBeforeUnloadListener();
                window.location.href = '/test-result/' + data.testId; // Redirect to results page
                // alert(data.success);
                // console.log(data.message);
            } else {
                alert(data.message || 'Failed to submit test.');
                submitButton.textContent = 'Submit Test';
                submitButton.classList.replace('bg-blue-800', 'bg-blue-600');
                submitButton.disabled = false;
                closeButton.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error submitting test:', error);
            alert('Failed to submit test. Please check the console for more details.');
            submitButton.textContent = 'Submit Test';
            submitButton.classList.replace('bg-blue-800', 'bg-blue-600');
            submitButton.disabled = false;
            closeButton.disabled = false;
        });
    }

    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');
    const interval = monitorIntervalTime;

    function startCamera() {
        navigator.mediaDevices.getUserMedia({ video: true, aspectRatio: 1.777 })
            .then(stream => {
                video.srcObject = stream;
                setInterval(captureFrame, interval);
            })
            .catch(err => console.error("Error accessing the camera: " + err));
    }

    function captureFrame() {
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        const imageData = canvas.toDataURL('image/jpg');
        sendVideoFrameToServer(imageData);
    }

    function sendVideoFrameToServer(imageData) {
        const testId = document.getElementById('testId').value;
        fetch('/api/monitor-frame', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ 
                image: imageData,
                test_id: testId
            })
        }).catch(err => console.error("Error sending frame to server: " + err));
    }

    function checkForSuspiciousActivity() {
        const testId = document.getElementById('testId').value;
        const toastCheck = document.getElementById('toast-for-checking');
        const toastCheckText = document.getElementById('toast-checking-reason');
        fetch(`/api/check-logs/${testId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data && data.reason && (!lastLogTimestamp || new Date(data.timestamp) > new Date(lastLogTimestamp))) {
                lastLogTimestamp = data.timestamp;
                toastCheckText.innerHTML = "Warning: " + data.reason;
                toastCheck.classList.remove('hidden');
                toastCheck.classList.add('slide-in-right');

                setTimeout(() => {
                    toastCheck.classList.remove('slide-in-right');
                    toastCheck.classList.add('slide-out-right');
                    setTimeout(() => {
                        toastCheck.classList.add('hidden');
                        toastCheck.classList.remove('slide-out-right');
                    }, 500);
                }, 4000);
            }
        })
        .catch(error => console.error('Error checking logs:', error));
    }

    suspiciousActivityInterval = setInterval(checkForSuspiciousActivity, logsCheckIntervalTime);

    startCamera();
    initializeTimer();
});
