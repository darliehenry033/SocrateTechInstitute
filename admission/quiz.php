<?php
require_once __DIR__ . '/../database/database.php';
require_once __DIR__ . '/../partials/header.php';

if (!function_exists('h')) {
    function h($v) {
        return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
    }
}

$applicant = null;
$error = '';
$applicationId = null;
$lastClass = null;

if (!isset($_GET['application_id'])) {
    $error = "Aucune demande d'admission trouvée. Veuillez soumettre votre formulaire d'inscription d'abord.";
} else {
    $applicationId = (int) $_GET['application_id'];
    $lastClass     = isset($_GET['last_class']) ? (int) $_GET['last_class'] : null;

    $sql = "SELECT 
                last_name,
                first_name,
                application_code,
                date_of_birth,
                last_class
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
        } else {
            // if last_class not passed in URL, take it from DB
            if ($lastClass === null && isset($applicant['last_class'])) {
                $lastClass = (int) $applicant['last_class'];
            }

            // compute age from date_of_birth (correct column)
            if (!empty($applicant['date_of_birth'])) {
                $birth = new DateTime($applicant['date_of_birth']);
                $today = new DateTime();
                $age   = $today->diff($birth)->y;
            } else {
                $age = null;
            }

        }
    } else {
        $error = "Erreur interne lors du chargement des informations du candidat.";
    }
}
?>

<main>
<section class="welcome-main-container">
    <section class="quiz-welcome-header-container">
        <div class="header-left nav-left">
            <a href="../index.php">
                <img src="../images/logowhite.png" alt="Socrate Tech Institute">
            </a>
        </div>

        <div class="header-right">
            <h2>Session: 2025-2026</h2>
        </div>
    </section>

    <section class="quiz-welcome-grid-container">

        <div class="quiz1 quiz-card">
            <h2>Bienvenue sur la Plateforme Officielle de Quiz d’Admission du Socrate Tech Institute.</h2>
            <p>Vous êtes invité(e) à compléter cette évaluation afin de finaliser votre candidature pour la session 2025–2026.</p>
            <p>Ce quiz nous permet d’évaluer votre niveau.</p>
        </div>

        <div class="quiz2 quiz-card">
            <h2>Informations sur le candidat</h2>

            <?php if ($error): ?>
                <p><?= h($error) ?></p>
            <?php elseif ($applicant): ?>
                <ul>
                    <li>Nom: <?= h($applicant['last_name']) ?></li>
                    <li>Prénom: <?= h($applicant['first_name']) ?></li>
                    <li>Code du candidat: <?= h($applicant['application_code']) ?></li>
                    <li>
                        Âge: <?= $age !== null ? h($age) . ' ans' : '—' ?>

                    </li>
                </ul>
            <?php else: ?>
                <p>Les informations du candidat ne sont pas disponibles.</p>
            <?php endif; ?>
        </div>

        <div class="quiz3 quiz-card">
            <h2>Règlements du Quiz</h2>
            <ul>
                <li>Le quiz comporte plusieurs questions à choix multiples.</li>
                <li>Une question ne peut pas être modifiée après validation.</li>
                <li>Aucune aide extérieure n’est autorisée.</li>
                <li>Veuillez répondre de manière honnête et individuelle.</li>
                <li>Le temps est limité, restez concentré(e).</li>
            </ul>
        </div>

        <div class="quiz4 quiz-card">
            <p>Tout est prêt. Vous pouvez maintenant commencer votre évaluation.</p>

            <?php if (!$error && $applicant && $lastClass !== null): ?>
                 <a href="quiz-exam.php?application_id=<?= $applicationId ?>&last_class=<?= $lastClass ?>&application_code=<?= urlencode($applicant['application_code']) ?>">
                 <button class="start-quiz-button button">Commencer</button>
                  </a>

                </a>
            <?php else: ?>
                <p>Impossible de démarrer le quiz : informations incomplètes.</p>
            <?php endif; ?>
        </div>
    </section>

   
</section>
</main>
</body>
</html>
