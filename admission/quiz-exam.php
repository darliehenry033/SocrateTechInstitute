<?php
session_start();
require_once __DIR__ . '/../database/database.php';
require_once __DIR__ . '/../partials/header.php';

$questions        = [];
$error            = '';
$timeLimitSeconds = 600; // 10 minutes
$quizStartTime    = null;

unset($_SESSION['quiz']);

if (!isset($_GET['last_class'])) {
    $error = "No class level provided for this quiz.";
} else {
    $classLevel = (int) $_GET['last_class'];

    if (
        isset($_SESSION['quiz']) &&
        isset($_SESSION['quiz']['classLevel']) &&
        $_SESSION['quiz']['classLevel'] === $classLevel &&
        isset($_SESSION['quiz']['questions']) &&
        is_array($_SESSION['quiz']['questions'])
    ) {
        $questions     = $_SESSION['quiz']['questions'];
        $quizStartTime = $_SESSION['quiz']['start_time'] ?? time();
    } else {
        $sql = "
(
    SELECT question_id, question_text, optionA, optionB, optionC, optionD, correct_answer, category_id
    FROM question_answers
    WHERE class_id = ? AND category_id = 1
    ORDER BY RAND()
    LIMIT 5
)
UNION ALL
(
    SELECT question_id, question_text, optionA, optionB, optionC, optionD, correct_answer, category_id
    FROM question_answers
    WHERE class_id = ? AND category_id = 2
    ORDER BY RAND()
    LIMIT 5
)
UNION ALL
(
    SELECT question_id, question_text, optionA, optionB, optionC, optionD, correct_answer, category_id
    FROM question_answers
    WHERE class_id = ? AND category_id = 3
    ORDER BY RAND()
    LIMIT 5
)
UNION ALL
(
    SELECT question_id, question_text, optionA, optionB, optionC, optionD, correct_answer, category_id
    FROM question_answers
    WHERE class_id = ? AND category_id = 4
    ORDER BY RAND()
    LIMIT 5
)
ORDER BY category_id, question_id
";

        $stmt = mysqli_prepare($connect, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'iiii', $classLevel, $classLevel, $classLevel, $classLevel);
            mysqli_stmt_execute($stmt);
            $result    = mysqli_stmt_get_result($stmt);
            $questions = mysqli_fetch_all($result, MYSQLI_ASSOC);

            if (empty($questions)) {
                $error = "No questions available for this class level.";
            } else {
                $quizStartTime = time();
                $_SESSION['quiz'] = [
                    'classLevel' => $classLevel,
                    'questions'  => $questions,
                    'start_time' => $quizStartTime,
                ];
            }
        } else {
            $error = "Internal error preparing quiz questions.";
        }
    }
}

if (!$quizStartTime) {
    $quizStartTime = time();
}
$elapsedSeconds   = max(0, time() - $quizStartTime);
$remainingSeconds = max(0, $timeLimitSeconds - $elapsedSeconds);

$applicationCode = isset($_GET['application_code'])
    ? htmlspecialchars($_GET['application_code'], ENT_QUOTES, 'UTF-8')
    : 'NO CODE';
?>
<main>
  <section class="quiz-main-container">
    <header class="quiz-header-container">
      <div class="header-left">
        <a href="../index.php" class="back-btn">
          <button class="button back-to-main-button">
            <i class="fa-solid fa-arrow-left"></i> Home
          </button>
        </a>
      </div>

      <div class="header-center">
        <!-- The JS will set this to 1/20, 2/20, ... -->
        <h2 id="questionCounter">1/1</h2>
      </div>

      <div class="header-right button">
        <span><?= $applicationCode ?></span>
      </div>
    </header>

    <section class="question-answers-grid">
      <?php if ($error): ?>
        <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>

      <?php elseif (!empty($questions)): ?>
        <div class="question-answer1-grid">
          <p id="questionText"></p>
        </div>

        <div class="timer">
          <div class="timer-title">
            <span>Time</span>
          </div>
          <div class="progress-container">
            <progress id="quizProgress" value="100" max="100"></progress>
          </div>
          <div class="remaining-time">
            <span id="remainingTime"></span>
          </div>
        </div>

        <div class="answers-flex-container">
          <button class="answer-card" type="button" data-option="A">
            <span class="answer-label">A</span>
            <p class="answer-text" id="optionAText"></p>
          </button>

          <button class="answer-card" type="button" data-option="B">
            <span class="answer-label">B</span>
            <p class="answer-text" id="optionBText"></p>
          </button>

          <button class="answer-card" type="button" data-option="C">
            <span class="answer-label">C</span>
            <p class="answer-text" id="optionCText"></p>
          </button>

          <button class="answer-card" type="button" data-option="D">
            <span class="answer-label">D</span>
            <p class="answer-text" id="optionDText"></p>
          </button>
        </div>

        <div class="switch-flex-container">
          <button class="nav-btn" id="prevBtn">
            <i class="fa-solid fa-arrow-left"></i>
          </button>
          <button class="nav-btn" id="nextBtn">
            <i class="fa-solid fa-arrow-right"></i>
          </button>
        </div>

        <div class="submit-btn-container">
          <!-- IMPORTANT: id="submitBtn" MUST match JS -->
          <button class="button submit-btn-quiz" id="submitBtn">Envoyer</button>
        </div>

      <?php else: ?>
        <p>No questions available for this class level.</p>
      <?php endif; ?>
    </section>
  </section>
</main>

<?php if (!$error && !empty($questions)): ?>
<script>
  const QUIZ_DATA = {
    questions: <?= json_encode($questions, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>,
    totalTime: <?= (int)$timeLimitSeconds ?>,
    timeLeft: <?= (int)$remainingSeconds ?>
  };
</script>
<script src="../js/quizEngine.js"></script>
<?php endif; ?>
