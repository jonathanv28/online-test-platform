document.addEventListener('DOMContentLoaded', function() {
    // localStorage.removeItem('test_start_time');
    const questions = document.querySelectorAll('.question');
    let currentQuestionIndex = 0;

    function showQuestion(index) {
        questions.forEach((question, idx) => {
            question.style.display = idx === index ? 'block' : 'none';
        });
        currentQuestionIndex = index;
        updateNavigationButtons();
        updateQuestionNav();
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
    }

    function updateQuestionNav() {
        document.querySelectorAll('.question-nav-btn').forEach((btn, idx) => {
            btn.style.backgroundColor = idx === currentQuestionIndex ? 'lightblue' : '';
        });
    }

    function startTimer(duration, startTime) {
        const timerElement = document.getElementById('timer');
        const interval = setInterval(() => {
            const now = new Date();
            const elapsed = Math.floor((now - startTime) / 1000);
            const remaining = duration - elapsed;
            if (remaining <= 0) {
                clearInterval(interval);
                document.getElementById('submit-test').submit(); // Automatically submit the test when time expires
                localStorage.removeItem('test_start_time');
            } else {
                const minutes = Math.floor(remaining / 60);
                const seconds = remaining % 60;
                timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }
        }, 1000);
    }

    const storedStartTime = localStorage.getItem('test_start_time');
    const startTime = storedStartTime ? new Date(storedStartTime) : new Date();
    if (!storedStartTime) localStorage.setItem('test_start_time', startTime.toISOString());

    const testDuration = parseInt(document.querySelector('.test-container').dataset.duration, 10) * 60;
    startTimer(testDuration, startTime);

    window.addEventListener('beforeunload', function (e) {
        const confirmationMessage = 'Are you sure you want to leave? Your test progress will be lost.';
        (e || window.event).returnValue = confirmationMessage;
        return confirmationMessage;
    });

    document.getElementById('next').addEventListener('click', () => navigateQuestion(1));
    document.getElementById('previous').addEventListener('click', () => navigateQuestion(-1));

    showQuestion(0);
    updateNavigationButtons();

    document.querySelectorAll('.question-nav-btn').forEach((btn, index) => {
        btn.addEventListener('click', () => showQuestion(index));
    });

    document.querySelectorAll('input[type="radio"]').forEach((input) => {
        input.addEventListener('change', () => {
            const questionIndex = Array.from(questions).indexOf(input.closest('.question'));
            const navBtn = document.querySelector(`.question-nav-btn[data-question-index="${questionIndex}"]`);
            if (navBtn) {
                navBtn.classList.add('answered');
            }
        });
    });

    document.getElementById('submit-test').addEventListener('click', function(event) {
        event.preventDefault();
        submitTest();
    });

    function submitTest() {
        const answers = {};
        document.querySelectorAll('.question').forEach(question => {
            const questionId = question.dataset.questionId;
            const selectedAnswer = question.querySelector('input[type="radio"]:checked');
            if (selectedAnswer) {
                answers[questionId] = selectedAnswer.value; // Capture the answer's value
            }
        });

        console.log(answers);

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
            console.log(data);
            if(data.success) {
                window.location.href = '/test-result/' + data.testId; // Redirect to results page
                alert(data.success);
                console.log(data.message);
            } else {
                alert(data.message || 'Failed to submit test.');
            }
        })
        .catch(error => {
            console.error('Error submitting test:', error);
            alert('Failed to submit test. Please check the console for more details.');
        });
    }

    // Video capturing and sending for cheating detection
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');
    const interval = 5000; // Capture every 5 seconds

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

    startCamera();
});
