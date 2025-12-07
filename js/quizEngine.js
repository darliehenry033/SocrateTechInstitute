//Quiz JS file


document.addEventListener('DOMContentLoaded', () => {
    if (!window.QUIZ_DATA || !Array.isArray(QUIZ_DATA.questions) || QUIZ_DATA.questions.length === 0) {
      console.error('QUIZ_DATA missing or invalid', window.QUIZ_DATA);
      return;
    }
  
    const questions      = QUIZ_DATA.questions;
    const TOTAL_TIME     = Number(QUIZ_DATA.totalTime) || 600;
    let   timeLeft       = Number(QUIZ_DATA.timeLeft);
    const totalQuestions = questions.length;
  
    if (!Number.isFinite(timeLeft) || timeLeft <= 0 || timeLeft > TOTAL_TIME) {
      timeLeft = TOTAL_TIME;
    }
  
    const questionTextEl  = document.getElementById('questionText');
    const optionATextEl   = document.getElementById('optionAText');
    const optionBTextEl   = document.getElementById('optionBText');
    const optionCTextEl   = document.getElementById('optionCText');
    const optionDTextEl   = document.getElementById('optionDText');
    const remainingTimeEl = document.getElementById('remainingTime');
    const progressEl      = document.getElementById('quizProgress');
    const prevBtn         = document.getElementById('prevBtn');
    const nextBtn         = document.getElementById('nextBtn');
    const submitBtn       = document.getElementById('submitBtn');
    const answerButtons   = document.querySelectorAll('.answer-card');
    const counterEl       = document.getElementById('questionCounter');
  
    if (
      !questionTextEl || !optionATextEl || !optionBTextEl ||
      !optionCTextEl || !optionDTextEl || !remainingTimeEl ||
      !progressEl   || !prevBtn       || !nextBtn ||
      !submitBtn    || !counterEl
    ) {
      console.error('Missing quiz DOM elements');
      return;
    }
  
    let currentQuestionIndex = 0;
    let quizFinished         = false;
  
    const answersStorageKey = 'sti_quiz_answers_' + window.location.pathname + window.location.search;
    let answers;
    try {
      const stored = localStorage.getItem(answersStorageKey);
      answers = stored ? JSON.parse(stored) : new Array(totalQuestions).fill(null);
    } catch (e) {
      answers = new Array(totalQuestions).fill(null);
    }
  
    function formatTime(seconds) {
      const min = Math.floor(seconds / 60);
      const sec = seconds % 60;
      return `${String(min).padStart(2, '0')}:${String(sec).padStart(2, '0')}`;
    }
  
    function updateTimerUI() {
      remainingTimeEl.textContent = formatTime(timeLeft);
      progressEl.value = (timeLeft / TOTAL_TIME) * 100;
    }
  
    function updateQuestionCounter() {
      counterEl.textContent = `${currentQuestionIndex + 1}/${totalQuestions}`;
    }
  
    function renderQuestion() {
      const q = questions[currentQuestionIndex];
      if (!q) return;
  
      questionTextEl.textContent = q.question_text;
      optionATextEl.textContent  = q.optionA;
      optionBTextEl.textContent  = q.optionB;
      optionCTextEl.textContent  = q.optionC;
      optionDTextEl.textContent  = q.optionD;
  
      answerButtons.forEach(btn => btn.classList.remove('answer-selected'));
  
      const saved = answers[currentQuestionIndex];
      if (saved) {
        const btn = document.querySelector(`.answer-card[data-option="${saved}"]`);
        if (btn) btn.classList.add('answer-selected');
      }
  
      prevBtn.disabled = currentQuestionIndex === 0;
      nextBtn.disabled = currentQuestionIndex === totalQuestions - 1;
  
      updateQuestionCounter();
    }
  
    updateTimerUI();
    renderQuestion();
  
    const timerInterval = setInterval(() => {
      if (quizFinished) {
        clearInterval(timerInterval);
        return;
      }
  
      timeLeft--;
  
      if (timeLeft <= 0) {
        timeLeft = 0;
        updateTimerUI();
        clearInterval(timerInterval);
        finishExam(true);
        return;
      }
  
      updateTimerUI();
    }, 1000);
  
    answerButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        if (quizFinished) return;
  
        const option = btn.getAttribute('data-option');
        answers[currentQuestionIndex] = option;
  
        try {
          localStorage.setItem(answersStorageKey, JSON.stringify(answers));
        } catch (e) {
          console.warn('localStorage save failed', e);
        }
  
        answerButtons.forEach(b => b.classList.remove('answer-selected'));
        btn.classList.add('answer-selected');
      });
    });

    prevBtn.addEventListener('click', () => {
      if (quizFinished) return;
      if (currentQuestionIndex > 0) {
        currentQuestionIndex--;
        renderQuestion();
      }
    });
  
    nextBtn.addEventListener('click', () => {
      if (quizFinished) return;
      if (currentQuestionIndex < totalQuestions - 1) {
        currentQuestionIndex++;
        renderQuestion();
      }
    });
  
    submitBtn.addEventListener('click', () => {
      if (quizFinished) return;
      const ok = confirm('Voulez-vous vraiment envoyer vos réponses ?');
      if (!ok) return;
      finishExam(false);
    });
  
    function finishExam(fromTimer) {
        if (quizFinished) return;
        quizFinished = true;
        clearInterval(timerInterval);
    
        let correctCount = 0;
        for (let i = 0; i < totalQuestions; i++) {
            const q = questions[i];
            const userAnswer = answers[i];
            const correct = q.correct_answer;
    
            if (userAnswer && correct && userAnswer === correct) {
                correctCount++;
            }
        }
    
        console.log("DEBUG count:", {
            correctCount,
            totalQuestions,
            answers,
            questions
        });
    
        const passed = (correctCount / totalQuestions) >= 0.7;
    
        if (fromTimer) {
            alert(`Le temps est écoulé.\nScore : ${correctCount}/${totalQuestions}`);
        } else {
            alert(`Vos réponses ont été envoyées.\nScore : ${correctCount}/${totalQuestions}`);
        }
    
        const params = new URLSearchParams(window.location.search);
        params.set("finished", "1");
        params.set("correct", correctCount.toString());
        params.set("total", totalQuestions.toString());
        params.set("passed", passed ? "1" : "0");
    
        window.location.href = "result.php?" + params.toString();
    }
    
  });
  