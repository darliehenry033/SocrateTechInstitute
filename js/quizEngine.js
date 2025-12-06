
//QUIZ ENGINE VERSION 1


//Validate Data 
if (!window.QUIZ_DATA || !Array.isArray(QUIZ_DATA.questions)) {
    console.error("QUIZ_DATA missing or invalid.");
}

// Extract Data
const questions = QUIZ_DATA.questions;
const TOTAL_TIME = QUIZ_DATA.totalTime;
let timeLeft = QUIZ_DATA.timeLeft;
const totalQuestions = questions.length;

//DOM Elements 
const questionTextEl = document.getElementById('questionText');
const optionATextEl  = document.getElementById('optionAText');
const optionBTextEl  = document.getElementById('optionBText');
const optionCTextEl  = document.getElementById('optionCText');
const optionDTextEl  = document.getElementById('optionDText');

const remainingTimeEl = document.getElementById('remainingTime');
const progressEl = document.getElementById('quizProgress');

const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');
const answerButtons = document.querySelectorAll('.answer-card');

//State
let currentQuestionIndex = 0;

//Load saved answers
const answersStorageKey = 'sti_quiz_answers_' + window.location.pathname + window.location.search;
let answers = [];
try {
    const stored = localStorage.getItem(answersStorageKey);
    answers = stored ? JSON.parse(stored) : new Array(totalQuestions).fill(null);
} catch (e) {
    answers = new Array(totalQuestions).fill(null);
}

//Timer
function formatTime(seconds) {
    const min = Math.floor(seconds / 60);
    const sec = seconds % 60;
    return `${String(min).padStart(2, '0')}:${String(sec).padStart(2, '0')}`;
}

remainingTimeEl.textContent = formatTime(timeLeft);
progressEl.value = (timeLeft / TOTAL_TIME) * 100;

const timerInterval = setInterval(() => {
    timeLeft--;

    if (timeLeft <= 0) {
        timeLeft = 0;
        clearInterval(timerInterval);
        finishExam();
    }

    remainingTimeEl.textContent = formatTime(timeLeft);
    progressEl.value = (timeLeft / TOTAL_TIME) * 100;

}, 1000);

//Rendering
function renderQuestion() {
    const q = questions[currentQuestionIndex];

    questionTextEl.textContent = q.question_text;
    optionATextEl.textContent = q.optionA;
    optionBTextEl.textContent = q.optionB;
    optionCTextEl.textContent = q.optionC;
    optionDTextEl.textContent = q.optionD;

    // Clear UI selection
    answerButtons.forEach(btn => btn.classList.remove('answer-selected'));

    // Restore previously selected answer
    const saved = answers[currentQuestionIndex];
    if (saved) {
        const btn = document.querySelector(`.answer-card[data-option="${saved}"]`);
        if (btn) btn.classList.add('answer-selected');
    }

    prevBtn.disabled = currentQuestionIndex === 0;
    nextBtn.disabled = currentQuestionIndex === totalQuestions - 1;
}

renderQuestion();

// Events
answerButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        const option = btn.getAttribute('data-option');
        answers[currentQuestionIndex] = option;

        localStorage.setItem(answersStorageKey, JSON.stringify(answers));

        answerButtons.forEach(b => b.classList.remove('answer-selected'));
        btn.classList.add('answer-selected');
    });
});

prevBtn.addEventListener('click', () => {
    if (currentQuestionIndex > 0) {
        currentQuestionIndex--;
        renderQuestion();
    }
});

nextBtn.addEventListener('click', () => {
    if (currentQuestionIndex < totalQuestions - 1) {
        currentQuestionIndex++;
        renderQuestion();
    }
});

//Finish Exam
function finishExam() {
    alert("Time is up!");
}

