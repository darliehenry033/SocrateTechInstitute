<?php
require_once __DIR__ . '/../database/database.php';
require_once __DIR__ . '/../partials/header.php';
?>


<main>
  <section class="quiz-main-container">
    <header class="quiz-header-container">
      <div class="header-left">
        <a href="../index.php">
          <img src="../images/logowhite.png" alt="Socrate Tech Institute">
        </a>
      </div>
    </header>

    <section class="question-answers-grid">
      <div class="question-answer1-grid">
        <p>Quelle est la valeur de 7 × 8 ?</p>
      </div>
      <div class="timer">
        <div class="timer-title">
        <span>Time</span>
        </div>
      <div class="progress-container">
      <progress id="quizProgress" value="70" max="100"></progress>    
     </div>

     <div class="remaining-time">
        <span>03:15</span>
     </div>
      </div>

      <div class="answers-flex-container">
        <button class="answer-card" type="button">
          <span class="answer-label">A</span>
          <p class="answer-text">48</p>
        </button>

        <button class="answer-card" type="button">
          <span class="answer-label">B</span>
          <p class="answer-text">54</p>
        </button>

        <button class="answer-card" type="button">
          <span class="answer-label">C</span>
          <p class="answer-text">56</p>
        </button>

        <button class="answer-card" type="button">
          <span class="answer-label">D</span>
          <p class="answer-text">65</p>
        </button>
      </div>

      <div class="switch-flex-container">
        <button class="nav-btn">
          <i class="fa-solid fa-arrow-left"></i>
        </button>
        <button class="nav-btn">
          <i class="fa-solid fa-arrow-right"></i>
        </button>
      </div>

    </section>
  </section>
</main>