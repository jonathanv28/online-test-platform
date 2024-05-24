// document.addEventListener('DOMContentLoaded', function() {
//     const testDuration = parseInt(document.querySelector('.test-container').dataset.duration, 10) * 60;
//     const questions = document.querySelectorAll('.question');
//     const totalQuestions = questions.length;
//     let currentQuestion = 0;

//     const storedStartTime = localStorage.getItem('start_time');
//     const startTime = storedStartTime ? new Date(storedStartTime) : new Date();
//     if (!storedStartTime) localStorage.setItem('start_time', startTime);

//     showQuestion(currentQuestion);
//     startTimer(testDuration, startTime);

//     document.getElementById('next').addEventListener('click', function() {
//         if (currentQuestion < totalQuestions - 1) {
//             currentQuestion++;
//             showQuestion(currentQuestion);
//         }
//     });

//     document.getElementById('previous').addEventListener('click', function() {
//         if (currentQuestion > 0) {
//             currentQuestion--;
//             showQuestion(currentQuestion);
//         }
//     });

//     function showQuestion(index) {
//         questions.forEach((el, i) => {
//             el.style.display = (i === index) ? 'block' : 'none';
//         });
//         document.getElementById('previous').style.display = (index === 0) ? 'none' : 'inline-block';
//         document.getElementById('next').style.display = (index === totalQuestions - 1) ? 'none' : 'inline-block';
//         document.getElementById('submit-form').style.display = (index === totalQuestions - 1) ? 'block' : 'none';
//     }

//     function startTimer(duration, startTime) {
//         const timerElement = document.getElementById('time');
//         const interval = setInterval(() => {
//             const now = new Date();
//             const elapsed = Math.floor((now - startTime) / 1000);
//             const remaining = duration - elapsed;
//             if (remaining <= 0) {
//                 clearInterval(interval);
//                 submitTest();
//             } else {
//                 const minutes = Math.floor(remaining / 60);
//                 const seconds = remaining % 60;
//                 timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
//             }
//         }, 1000);
//     }

//     function submitTest() {
//         const answers = {};
//         document.querySelectorAll('.question').forEach(question => {
//             const questionId = question.dataset.questionId;
//             const selected = question.querySelector('input[type="radio"]:checked');
//             if (selected) {
//                 answers[questionId] = selected.value;
//             }
//         });
//         fetch('/submit-test', {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json',
//                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//             },
//             body: JSON.stringify({answers})
//         }).then(response => response.json())
//           .then(data => {
//               alert('Test submitted successfully.');
//               window.location.href = '/results/' + data.testId;
//           }).catch(error => {
//               console.error('Error submitting test:', error);
//               alert('Failed to submit test.');
//           });
//     }
// });

document.addEventListener('DOMContentLoaded', function() {
    // localStorage.removeItem('test_start_time');
    const questions = document.querySelectorAll('.question');
    let currentQuestionIndex = 0;

    function showQuestion(index) {
        questions.forEach((question, idx) => {
            question.style.display = idx === index ? 'block' : 'none';
        });
    }

    function navigateQuestion(step) {
        currentQuestionIndex += step;
        currentQuestionIndex = Math.max(0, Math.min(currentQuestionIndex, questions.length - 1));
        showQuestion(currentQuestionIndex);
        updateNavigationButtons();
    }

    function updateNavigationButtons() {
        document.getElementById('previous').style.display = currentQuestionIndex > 0 ? 'inline-block' : 'none';
        document.getElementById('next').style.display = currentQuestionIndex < questions.length - 1 ? 'inline-block' : 'none';
        document.getElementById('submit-test').style.display = currentQuestionIndex === questions.length - 1 ? 'block' : 'none';
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
            if(data.success) {
                window.location.href = '/tests/' + data.testId + '/result'; // Redirect to results page
            } else {
                alert(data.message || 'Failed to submit test.');
            }
        })
        .catch(error => {
            console.error('Error submitting test:', error);
            alert('Failed to submit test. Please check the console for more details.');
        });
    }
    
});

