<?php
require_once __DIR__ . '/../database/database.php';
require_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../partials/applicationheader.php';

$last_name = $first_name = $date_of_birth = $sex = $birthplace =
$phone = $email = $address = $last_class = $last_school = $modern_course = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

  if (
    empty($last_name)    || empty($first_name)   || empty($date_of_birth) ||
    empty($sex)          || empty($birthplace)   || empty($phone)        ||
    empty($email)        || empty($address)      || empty($last_class)   ||
    empty($last_school)  || empty($modern_course)
  ) {
    echo "The fields cannot be empty";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Incorrect email format";
  } elseif (!preg_match('/^\+?[0-9]{8,15}$/', $phone)) {
    echo "Invalid phone number format";
  } else {
    
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
            <form action="" method="POST" enctype="multipart/form-data">
              <div class="personal-information personal-information-grid-part-1">
               
                
                <div class="photo-upload">
                  <label for="photoInput" class="photo-frame" id="photoFrame">
                    <span>Ajouter Photo</span>
                  </label>
                  <input type="file" id="photoInput" class="photo-profile" name="photo-profile" accept="image/*" hidden>
                </div>
                
          
                <label for="lastname">Nom de Famille</label>
                <input type="text" class="fullname" name="lastName" required>

                <label for="firstname">Prénom</label>
                <input type="text" class="fullname" name="firstName" required>
          
                <label for="dateOfBirth">Date de Naissance</label>
                <input type="date" class="dateOfBirth" name="dateOfBirth" required>
          
                <label for="sexe">Sexe</label><br>
                <input type="radio" id="homme" name="sexe" value="Homme" required>
                <label for="homme">Homme</label>
          
                <input type="radio" id="femme" name="sexe" value="Femme">
                <label for="femme">Femme</label>
          
                <label for="birthplace">Lieu de Naissance (Ville en Haïti)</label>
                <select id="birthplace" name="birthplace" required>
                  <option value="">Sélectionnez une ville</option>
                  <option value=""><script>loadHaitiCities();</script></option>
                </select>
                <label for="phoneNumber">Téléphone</label>
                <input type="phone" class="phone" name="phone">
  
                <label for="email">Email</label>
                <input type="email" class="email" name="email">
  
                <label for="address">Adresse Actuelle</label>
                <input type="text" class="address" name="address">
  
              </div>
              
              <div class="personal-information-grid-part-2">
                <div class="academic-information">
                  <legend>Informations Académiques</legend>
                  <div class="last-grade-completed">
                    <label for="lastclass">Dernier niveau complété : </label>
                    <select name="lastclass" id="lastclass">
                      <option value="">7e</option>
                      <option value="">8e</option>
                      <option value="">9e</option>
                      <option value="">NSI</option>
                      <option value="">NSII</option>
                      <option value="">NSIII</option>
                      <option value="">NSIV</option>
                    </select>
                  </div>
                  
                  <div class="last-school-completed">
                    <label for="lastschool">Dernier établissement fréquenté</label>
                    <input type="text" name="lastSchool" class="lastSchool">
                  </div>
  
                  
                  <label for="modernCourses">Intérêts pour les cours modernes :</label>
                  <div class="programming">
                    <input type="radio" name="modernCourse" id="programming">
                    <label for="programming">Programmation</label>
                  </div>
  
                     <div class="ai">
                      <input type="radio" name="modernCourse" id="AI" >
                      <label for="AI">Intelligence Artificielle</label>
                     </div>
                 
                        <div class="cybersecurity">
                          <input type="radio" name="modernCourse" id="cybersecurity" >
                          <label for="cybersecurity">Cybersécurité</label>
                        </div>
                       <div class="agriculture">
                        <input type="radio" name="modernCourse" id="agriculture" >
                        <label for="agriculture">Agriculture</label>
                       </div> 
                       <div class="first-aid">
                        <input type="radio" name="modernCourse" id="firstAid" >
                  <label for="firstAid">Premiers Soins</label>
                       </div>
  
    
                 
                   
                  
    
                </div>
    
                <div class="requiredDocuments">
                  <legend>Documents Requis</legend>
                
                  <section class="required-documents-flex-container">
                    <div class="birthAct" id="birthActBox">
                      <label for="birthActInput">Acte de Naissance ou Extrait des Archives</label>
                      <input type="file" id="birthActInput" class="birthAct-doc" name="birthAct" hidden>
                      <span class="file-name">Aucun fichier choisi</span>
                    </div>
                
                    <div class="transcript" id="transcriptsBox">
                      <label for="transcriptsInput">Relevés de notes</label>
                      <strong>(incluant toutes les classes précédentes et la dernière classe)</strong>
                      <input type="file" id="transcriptsInput" class="transcript-doc" name="transcripts[]" multiple hidden>
                      <span class="file-name">Aucun fichier choisi</span>
                    </div>
                  </section>
                </div>
                
    
                <div class="confirmValidation">
                  <div class="validation-input">
                    <input type="checkbox" id="validation" name="validation">
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







  

  
<script src="js/script.js"></script>
 

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous"></script>
</body>
</html>
