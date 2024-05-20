document.addEventListener('DOMContentLoaded', function() {
    const testDuration = parseInt(document.querySelector('.test-container').dataset.duration, 10) * 60;
    let currentQuestion = 1;
    showQuestion(currentQuestion);
    startTimer(testDuration);
});

function showQuestion(number) {
    document.querySelectorAll('.question').forEach((el, index) => {
        el.style.display = (index + 1 === number) ? 'block' : 'none';
    });
}

function nextQuestion() {
    const totalQuestions = document.querySelectorAll('.question').length;
    if (currentQuestion < totalQuestions) {
        currentQuestion++;
        showQuestion(currentQuestion);
    }
}

function startTimer(seconds) {
    const timerElement = document.getElementById('time');
    let remaining = seconds;
    const interval = setInterval(() => {
        const minutes = Math.floor(remaining / 60);
        const seconds = remaining % 60;
        timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        if (remaining <= 0) {
            clearInterval(interval);
            submitTest();
        }
        remaining--;
    }, 1000);
}

function submitTest() {
    const answers = {};
    document.querySelectorAll('.question').forEach(question => {
        const questionId = question.dataset.questionId;
        const selected = question.querySelector('input[type="radio"]:checked');
        if (selected) {
            answers[questionId] = selected.value;
        }
    });
    // Submit these answers to the server
    fetch('/submit-test', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({answers})
    }).then(response => response.json())
      .then(data => {
          alert('Test submitted successfully.');
          window.location.href = '/results/' + data.testId;
      }).catch(error => {
          console.error('Error submitting test:', error);
          alert('Failed to submit test.');
      });
}
