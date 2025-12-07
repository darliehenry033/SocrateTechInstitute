<?php
session_start();
require_once __DIR__ . '/../database/database.php';
require_once __DIR__ . '/../partials/header.php';

/* ---------- Small helper ---------- */
function h($v) {
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}

/* ---------- Read GET params ---------- */
// Required for result
$applicationId = isset($_GET['application_id']) ? (int) $_GET['application_id'] : null;
$finished      = isset($_GET['finished']) ? (int) $_GET['finished'] : 0;

// Sent by JS
$correct = isset($_GET['correct']) ? (int) $_GET['correct'] : null;
$total   = isset($_GET['total'])   ? (int) $_GET['total']   : null;

$applicant = null;
$error     = '';

/* ---------- Basic validation ---------- */
if (!$finished || $applicationId === null || $correct === null || $total === null) {
    $error = "Les informations du quiz sont incomplètes. Veuillez contacter l'administration.";
} else {
    // Sanity checks
    if ($total <= 0) {
        // fallback: try session if exists
        if (isset($_SESSION['quiz']['questions']) && is_array($_SESSION['quiz']['questions'])) {
            $total = max(1, count($_SESSION['quiz']['questions']));
        } else {
            $total = 1;
        }
    }

    if ($correct < 0) {
        $correct = 0;
    }
    if ($correct > $total) {
        $correct = $total;
    }

    // Compute percentage
    $scorePercent = round(($correct / $total) * 100);

    // Admission rule (70%)
    $isAdmitted = $scorePercent >= 70;

    // Load applicant
    $sql = "SELECT application_code, first_name, last_name, email 
            FROM application
            WHERE application_id = ?";
    $stmt = mysqli_prepare($connect, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $applicationId);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $applicant = mysqli_fetch_assoc($res);

        if (!$applicant) {
            $error = "Candidat introuvable pour cette application.";
        }
    } else {
        $error = "Erreur interne lors du chargement des données.";
    }
}

/* ---------- Build status / message ---------- */
$status        = null;
$statusMessage = null;

if (!$error && $applicant) {
    if ($isAdmitted) {
        $status = "Admis(e)";
        $statusMessage =
            "Félicitations ! Vous avez obtenu $correct/$total (soit $scorePercent%). " .
            "Vous êtes admis(e) au Socrate Tech Institute, sous réserve des autres étapes administratives.";
    } else {
        $status = "Non admis(e)";
        $statusMessage =
            "Vous avez obtenu $correct/$total (soit $scorePercent%). " .
            "Vous n'avez pas atteint la note minimale d'admission (70%). " .
            "Vous pourrez retenter votre chance lors de la prochaine session.";
    }

    // Optional email notification
    if (!empty($applicant['email'])) {
        $to      = $applicant['email'];
        $subject = "Avis d'admission - Socrate Tech Institute";
        $name    = $applicant['first_name'] . ' ' . $applicant['last_name'];
        $code    = $applicant['application_code'];

        $message = "Bonjour $name,\n\n"
                 . "Voici le résultat de votre quiz d'admission (code candidat : $code).\n"
                 . "Score : $correct/$total (soit $scorePercent%)\n"
                 . "Décision : $status\n\n"
                 . $statusMessage . "\n\n"
                 . "Cordialement,\n"
                 . "Socrate Tech Institute";

        @mail($to, $subject, $message);
    }
}
?>

<main>
  <section class="quiz-main-container">
    <header class="quiz-header-container">
      <div class="header-left">
        <a href="../index.php" class="back-btn">
          <button class="button back-to-main-button">
            <i class="fa-solid fa-arrow-left"></i> Accueil
          </button>
        </a>
      </div>

      <div class="header-center">
        <h2>Résultat du Quiz d'Admission</h2>
      </div>

      <div class="header-right">
        <?php if ($applicant): ?>
          <span><?= h($applicant['application_code']) ?></span>
        <?php endif; ?>
      </div>
    </header>

    <section class="question-answers-grid result-card">
      <?php if ($error): ?>
        <p><?= h($error) ?></p>
      <?php else: ?>
        <h3>Bonjour <?= h($applicant['first_name'] . ' ' . $applicant['last_name']) ?>,</h3>

        <p><strong>Score obtenu :</strong>
          <?= h($correct) ?>/<?= h($total) ?> (<?= h($scorePercent) ?>%)</p>

        <p><strong>Décision :</strong> <?= h($status) ?></p>

        <p><?= h($statusMessage) ?></p>
      <?php endif; ?>
    </section>
  </section>
</main>
</body>
</html>

