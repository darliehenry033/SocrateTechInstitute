<?php
require_once __DIR__ . '/../database/database.php';
require_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../partials/applicationheader.php';

$last_name = $first_name = $date_of_birth = $sex = $birthplace =
$phone = $email = $address = $last_class = $last_school = $modern_course = "";
$error = "";

/* --------LOAD CLASSES FOR SELECT -------- */
$classesList = [];
$classSql = "SELECT class_id, class_name FROM classes ORDER BY class_name";
if ($res = mysqli_query($connect, $classSql)) {
    while ($row = mysqli_fetch_assoc($res)) {
        $classesList[] = $row;
    }
    mysqli_free_result($res);
}

function handle_upload(
    string $fieldName,
    string $subDir,
    array $allowedExt,
    array $allowedMime,
    bool $multiple = false,
    int $maxSizeBytes = 5 * 1024 * 1024
): array {
    if (!isset($_FILES[$fieldName])) {
        return [];
    }

    $files = $_FILES[$fieldName];
    $savedPaths = [];

    $names     = $multiple ? $files['name']     : [$files['name']];
    $tmpNames  = $multiple ? $files['tmp_name'] : [$files['tmp_name']];
    $sizes     = $multiple ? $files['size']     : [$files['size']];
    $errors    = $multiple ? $files['error']    : [$files['error']];

    // Base upload directory at project root
    $baseDir = __DIR__ . '/../uploads';
    if (!is_dir($baseDir)) {
        mkdir($baseDir, 0755, true);
    }

    // Subdirectory (profile_photos, birth_acts, transcripts, etc.)
    $targetDir = $baseDir . '/' . $subDir;
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);

    foreach ($names as $index => $originalName) {
        if ($errors[$index] === UPLOAD_ERR_NO_FILE) {
            // No file for this index
            continue;
        }

        if ($errors[$index] !== UPLOAD_ERR_OK) {
            throw new RuntimeException("Upload error code {$errors[$index]} for {$fieldName}");
        }

        $tmp  = $tmpNames[$index];
        $size = $sizes[$index];

        if ($size > $maxSizeBytes) {
            throw new RuntimeException("File too large for {$fieldName}");
        }

        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExt, true)) {
            throw new RuntimeException("Invalid extension for {$fieldName}");
        }

        $mime = finfo_file($finfo, $tmp);
        if (!in_array($mime, $allowedMime, true)) {
            throw new RuntimeException("Invalid MIME type for {$fieldName}");
        }

        $newName  = uniqid($fieldName . '_', true) . '.' . $ext;
        $fullPath = $targetDir . '/' . $newName;

        if (!move_uploaded_file($tmp, $fullPath)) {
            throw new RuntimeException("Failed to move uploaded file for {$fieldName}");
        }

        // Relative path to store later in DB
        $relativePath = 'uploads/' . $subDir . '/' . $newName;
        $savedPaths[] = $relativePath;
    }

    finfo_close($finfo);
    return $savedPaths;
}

/* ------------HANDLE POST ---------------*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $last_name     = mysqli_real_escape_string($connect, trim(strip_tags($_POST['lastName']    ?? '')));
    $first_name    = mysqli_real_escape_string($connect, trim(strip_tags($_POST['firstName']   ?? '')));
    $date_of_birth = trim(strip_tags($_POST['dateOfBirth'] ?? ''));
    $sex           = mysqli_real_escape_string($connect, trim(strip_tags($_POST['sexe']        ?? '')));
    $birthplace    = mysqli_real_escape_string($connect, trim(strip_tags($_POST['birthplace']  ?? '')));
    $phone         = mysqli_real_escape_string($connect, trim(strip_tags($_POST['phone']       ?? '')));
    $email         = mysqli_real_escape_string($connect, trim(filter_var($_POST['email']       ?? '', FILTER_SANITIZE_EMAIL)));
    $address       = mysqli_real_escape_string($connect, trim(strip_tags($_POST['address']     ?? '')));
    $last_class    = mysqli_real_escape_string($connect, trim(strip_tags($_POST['lastclass']   ?? '')));
    $last_school   = mysqli_real_escape_string($connect, trim(strip_tags($_POST['lastSchool']  ?? '')));
    $modern_course = mysqli_real_escape_string($connect, trim(strip_tags($_POST['modernCourse']?? '')));

    // --VALIDATION--------
    if (
        empty($last_name)    || empty($first_name)   || empty($date_of_birth) ||
        empty($sex)          || empty($birthplace)   || empty($phone)        ||
        empty($email)        || empty($address)      || empty($last_class)   ||
        empty($last_school)  || empty($modern_course)
    ) {
        $error = "The fields cannot be empty";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Incorrect email format";
    } elseif (!preg_match('/^\+?[0-9]{8,15}$/', $phone)) {
        $error = "Invalid phone number format";
    }

    // If no validation error, handle uploads and DB
    if ($error === "") {
        try {
            // One profile photo
            $photoPaths = handle_upload(
                'photo_profile',
                'profile_photos',
                ['jpg','jpeg','png','gif'],
                ['image/jpeg','image/png','image/gif'],
                false
            );

            // One birth act
            $birthActPaths = handle_upload(
                'birth_act',
                'birth_acts',
                ['jpg','jpeg','png','pdf'],
                ['image/jpeg','image/png','application/pdf'],
                false
            );

            // Multiple transcripts
            $transcriptPaths = handle_upload(
                'transcripts',
                'transcripts',
                ['jpg','jpeg','png','pdf'],
                ['image/jpeg','image/png','application/pdf'],
                true
            );

            $photoPath      = $photoPaths[0]    ?? null;
            $birthActPath   = $birthActPaths[0] ?? null;
            $transcriptsStr = $transcriptPaths ? implode(';', $transcriptPaths) : null;

            // INSERT INTO DB 
            $sql = "INSERT INTO application 
                    (last_name, first_name, date_of_birth, sex, birthplace,
                     phone, email, address, last_class, last_school, modern_courses,
                     photo_path, birth_act_path, transcripts_paths)
                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

            $stmt = mysqli_prepare($connect, $sql);
            if (!$stmt) {
                throw new RuntimeException('DB prepare failed: ' . mysqli_error($connect));
            }

            mysqli_stmt_bind_param(
                $stmt,
                'ssssssssssssss',
                $last_name,
                $first_name,
                $date_of_birth,
                $sex,
                $birthplace,
                $phone,
                $email,
                $address,
                $last_class,
                $last_school,
                $modern_course,
                $photoPath,
                $birthActPath,
                $transcriptsStr
            );

            if (!mysqli_stmt_execute($stmt)) {
                throw new RuntimeException('DB insert failed: ' . mysqli_error($connect));
            }

            $applicationId = mysqli_insert_id($connect);
            mysqli_stmt_close($stmt);

            // GENERATE APPLICATION CODE
            $offset          = 100; // APP-101, 102, ...
            $codeNumber      = $applicationId + $offset;
            $applicationCode = 'APP-' . $codeNumber;

            $updateSql  = "UPDATE application SET application_code = ? WHERE application_id = ?";
            $updateStmt = mysqli_prepare($connect, $updateSql);
            mysqli_stmt_bind_param($updateStmt, 'si', $applicationCode, $applicationId);
            mysqli_stmt_execute($updateStmt);
            mysqli_stmt_close($updateStmt);

            //  REDIRECT TO QUIZ
            header("Location: quiz.php?application_id=" . $applicationId);
            exit;

        } catch (RuntimeException $e) {
            $error = $e->getMessage();
        }
    }
}
?>

<main>
  <div class="application-notice-container"> 
    <div class="application-notice-item">
      <p><i class="fa-solid fa-quote-left"></i>Remplissez ce formulaire pour soumettre votre candidature et rejoindre la communauté Socrate Tech Institute. Toutes les informations seront traitées de manière confidentielle.<i class="fa-solid fa-quote-right"></i></p>
    </div>
  </div>

  <div class="application-form-container">
  <?php if (!empty($error)): ?>
      <div class="error_message">
        <p><i class="fa-solid fa-circle-exclamation"></i><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
      </div>
    <?php endif; ?>

    

    <form action="" method="POST" enctype="multipart/form-data">
  <div class="personal-information personal-information-grid-part-1">
    <div class="photo-upload">
      <label for="photoInput" class="photo-frame" id="photoFrame">
        <span id="photoText">Ajouter Photo</span>
        <img id="photoPreview" alt="Prévisualisation"
             style="display:none; max-width:100%; height:auto; border-radius:10px;">
      </label>
      <input type="file" id="photoInput" class="photo-profile"
             name="photo_profile" accept="image/*" hidden>
    </div>

    <label for="lastname">Nom de Famille</label>
    <input type="text" class="fullname" name="lastName" required
           value="<?= htmlspecialchars($last_name, ENT_QUOTES, 'UTF-8'); ?>">

    <label for="firstname">Prénom</label>
    <input type="text" class="fullname" name="firstName" required
           value="<?= htmlspecialchars($first_name, ENT_QUOTES, 'UTF-8'); ?>">

    <label for="dateOfBirth">Date de Naissance</label>
    <input type="date" class="dateOfBirth" name="dateOfBirth" required
           value="<?= htmlspecialchars($date_of_birth, ENT_QUOTES, 'UTF-8'); ?>">

    <label for="sexe">Sexe</label><br>
    <input type="radio" id="homme" name="sexe" value="Homme" required
           <?= $sex === 'Homme' ? 'checked' : '' ?>>
    <label for="homme">Homme</label>

    <input type="radio" id="femme" name="sexe" value="Femme"
           <?= $sex === 'Femme' ? 'checked' : '' ?>>
    <label for="femme">Femme</label>

    <label for="birthplace">Lieu de Naissance (Ville en Haïti)</label>
    <select id="birthplace" name="birthplace" required>
      <option value="">Sélectionnez une ville</option>
      <!-- here you should eventually generate options in PHP
           and set selected based on $birthplace -->
      <option value=""><script>loadHaitiCities();</script></option>
    </select>

    <label for="phoneNumber">Téléphone</label>
    <input type="phone" class="phone" name="phone"
           value="<?= htmlspecialchars($phone, ENT_QUOTES, 'UTF-8'); ?>">

    <label for="email">Email</label>
    <input type="email" class="email" name="email"
           value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">

    <label for="address">Adresse Actuelle</label>
    <input type="text" class="address" name="address"
           value="<?= htmlspecialchars($address, ENT_QUOTES, 'UTF-8'); ?>">
  </div>
  
  <div class="personal-information-grid-part-2">
    <div class="academic-information">
      <legend>Informations Académiques</legend>
      <div class="last-grade-completed">
        <label for="lastclass">Dernier niveau complété : </label>
        <select name="lastclass" id="lastclass" required>
          <option value="">Select a class</option>
          <?php foreach ($classesList as $cls): ?>
            <?php $id = (int)$cls['class_id']; ?>
            <option value="<?= $id; ?>"
              <?= ($last_class == $id) ? 'selected' : '' ?>>
              <?= htmlspecialchars($cls['class_name'], ENT_QUOTES, 'UTF-8'); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      
      <div class="last-school-completed">
        <label for="lastschool">Dernier établissement fréquenté</label>
        <input type="text" name="lastSchool" class="lastSchool"
               value="<?= htmlspecialchars($last_school, ENT_QUOTES, 'UTF-8'); ?>">
      </div>

      <label for="modernCourses">Intérêts pour les cours modernes :</label>
      <div class="programming">
        <input type="radio" name="modernCourse" id="programming"
               value="programmation" required
               <?= $modern_course === 'programmation' ? 'checked' : '' ?>>
        <label for="programming">Programmation</label>
      </div>

      <div class="ai">
        <input type="radio" name="modernCourse" id="AI"
               value="intelligence_artificielle"
               <?= $modern_course === 'intelligence_artificielle' ? 'checked' : '' ?>>
        <label for="AI">Intelligence Artificielle</label>
      </div>
  
      <div class="cybersecurity">
        <input type="radio" name="modernCourse" id="cybersecurity"
               value="cybersecurite"
               <?= $modern_course === 'cybersecurite' ? 'checked' : '' ?>>
        <label for="cybersecurity">Cybersécurité</label>
      </div>

      <div class="agriculture">
        <input type="radio" name="modernCourse" id="agriculture"
               value="agriculture"
               <?= $modern_course === 'agriculture' ? 'checked' : '' ?>>
        <label for="agriculture">Agriculture</label>
      </div> 

      <div class="first-aid">
        <input type="radio" name="modernCourse" id="firstAid"
               value="premiers_soins"
               <?= $modern_course === 'premiers_soins' ? 'checked' : '' ?>>
        <label for="firstAid">Premiers Soins</label>
      </div>
    </div>

    <div class="requiredDocuments">
      <legend>Documents Requis</legend>
      <section class="required-documents-flex-container">
        <div class="birthAct file-box" id="birthActBox">
          <label for="birthActInput">
            <span>Acte de Naissance ou Extrait des Archives</span>
            <span class="file-name">Aucun fichier choisi</span>
          </label>
          <input type="file" id="birthActInput" class="birthAct-doc"
                 name="birth_act" accept=".jpg,.jpeg,.png,.pdf" hidden>
        </div>

        <div class="transcript file-box" id="transcriptsBox">
          <label class="file-click-zone">
            <span class="file-title">Relevés de notes</span>
            <strong>(incluant toutes les classes précédentes et la dernière classe)</strong>
            <span class="file-name">Aucun fichier choisi</span>
          </label>
          <input type="file" id="transcriptsInput" name="transcripts[]" multiple
                 accept=".jpg,.jpeg,.png,.pdf" hidden>
        </div>
      </section>
    </div>

    <div class="confirmValidation">
      <div class="validation-input">
        <input type="checkbox" id="validation" name="validation"
               <?= !empty($_POST['validation']) ? 'checked' : '' ?>>
        <label for="textConfirm">Je Certifie que toutes les informations sont exactes et que les documents téléchargés sont authentiques.</label>
      </div>
      <div class="button-container">
        <button id="submitRequest" class="button submit-button">Soumettre ma candidature</button>
      </div>
    </div>
  </div>
</form>

  </div>

  <?php include __DIR__ . '/../partials/customfooter.php'; ?>
</main>

<!-- JS for photo preview + file names -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  //PHOTO PREVIEW 
  const photoInput    = document.getElementById('photoInput');
  const photoPreview  = document.getElementById('photoPreview');
  const photoText     = document.getElementById('photoText');

  if (photoInput && photoPreview && photoText) {
    photoInput.addEventListener('change', function () {
      const file = photoInput.files[0];
      if (!file) {
        photoPreview.style.display = 'none';
        photoText.style.display    = 'block';
        return;
      }

      const reader = new FileReader();
      reader.onload = function (e) {
        photoPreview.src = e.target.result;
        photoPreview.style.display = 'block';
        photoText.style.display    = 'none';
      };
      reader.readAsDataURL(file);
    });
  }

  // click label opens file input for all custom boxes
  function attachFileName(inputId, boxId) {
    const input = document.getElementById(inputId);
    const box   = document.getElementById(boxId);
    if (!input || !box) return;

    const label = box.querySelector('label');
    const span  = box.querySelector('.file-name');

    if (label) {
      label.addEventListener('click', function () {
        input.click();
      });
    }
    input.addEventListener('change', function () {
      if (!input.files || input.files.length === 0) {
        span.textContent = 'Aucun fichier choisi';
        return;
      }

      if (input.files.length === 1) {
        span.textContent = input.files[0].name;
      } else {
        const names = Array.from(input.files).map(f => f.name);
        span.textContent = names.join(', ');
      }
    });
  }

  attachFileName('birthActInput', 'birthActBox');
  attachFileName('transcriptsInput', 'transcriptsBox');
});



</script>

<script src="../js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous"></script>
</body>
</html>
