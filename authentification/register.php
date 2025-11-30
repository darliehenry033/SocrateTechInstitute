<?php
session_start();

require_once __DIR__ . '/../database/database.php';
require_once __DIR__ . '/../partials/functions.php';
require_once __DIR__ . '/../partials/linkheader.php';

if (is_user_logged_in()) {
    redirect('admindash.php');
}

$username = $email = $password = $password_confirm = $role = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = isset($_POST['username'])
        ? mysqli_real_escape_string($connect, trim(strip_tags($_POST['username'])))
        : '';

    $email = isset($_POST['email'])
        ? mysqli_real_escape_string(
            $connect,
            trim(strip_tags(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)))
        )
        : '';

    $password = isset($_POST['password'])
        ? mysqli_real_escape_string($connect, trim(strip_tags($_POST['password'])))
        : '';

    $password_confirm = isset($_POST['password_confirm'])
        ? mysqli_real_escape_string($connect, trim(strip_tags($_POST['password_confirm'])))
        : '';

    $role = isset($_POST['role'])
        ? mysqli_real_escape_string($connect, trim(strip_tags($_POST['role'])))
        : '';

    // ✅ fix: each field checked separately
    if (
        empty($username) ||
        empty($email) ||
        empty($password) ||
        empty($password_confirm) ||
        empty($role)
    ) {
        $error = "The fields cannot be empty";
    } elseif (user_exists($connect, $username)) {
        $error = "Username already exists. Please pick another one.";
    } elseif ($password !== $password_confirm) {
        $error = "Password and Password Confirm cannot be different";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Incorrect Email Format";
    } elseif (strlen($password) < 8 || strlen($password_confirm) < 8) {
        $error = "Password and Password Confirm should have at least 8 characters";
    } else {

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(username, email, password, role) VALUES(?, ?, ?, ?)";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, 'ssss', $username, $email, $password_hash, $role);

        if (mysqli_stmt_execute($stmt)) {

            $routes = [
                'parent'  => 'parentdash.php',
                'teacher' => 'teacherdash.php',
                'student' => 'studentdash.php',
                'admin'   => 'admindash.php'
            ];

            if (!isset($routes[$role])) {
                $error = "Invalid role selected";
            } else {
                $_SESSION['username']  = $username;
                $_SESSION['logged_in'] = true;
                $_SESSION['role']      = $role;
                redirect($routes[$role]);
            }
        } else {
            $error = "Failed to insert data into DB.";
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<div class="register-container-overlay-bg">
  <div class="regislog-container">
    <div class="regislog-left">
      <a href="../index.php"><img src="../images/logowhite.png" alt=""></a>
      <h1>Register</h1>
    </div>

    <div class="regislog-right">
      <div class="closing-icon">
        <i class="fa-solid fa-xmark"></i>
      </div>

      <form action="" enctype="multipart/form-data" method="POST" id="formID">
        <?php if ($error): ?>
          <div class="error_message">
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
          </div>
        <?php endif; ?>

        <input
          type="text"
          placeholder="Nom d'utilisateur: "
          class="username"
          name="username"
          value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>"
        >

        <input
          type="email"
          placeholder="Votre Email: "
          class="email"
          name="email"
          value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
        >

        <input
          type="password"
          placeholder="Votre Mot-de-Passe: "
          name="password"
          class="password"
        >

        <input
          type="password"
          name="password_confirm"
          placeholder="Confirmer votre Mot-de-passe: "
          class="password_confirm"
        >

        <select name="role" id="role">
          <option value="parent">Parent</option>
          <option value="student">Student</option>
          <option value="teacher">Teacher</option>
          <option value="admin">Admin</option>
        </select>

        <p><span>Ou</span><br>Enregistrer avec les réseaux sociaux</p>

        <div class="social-media">
          <span class="social-icon"><i class="fab fa-google"></i></span>
          <span class="social-icon"><i class="fab fa-facebook"></i></span>
          <span class="social-icon"><i class="fab fa-github"></i></span>
          <span class="social-icon"><i class="fas fa-link"></i></span>
        </div>

        <button
          class="contact button button-register"
          type="submit"
          name="register_submit"
          style="color: white !important;"
        >
          Enregistrer
        </button>
      </form>
    </div>
  </div>
</div>

<?php
// ✅ correct footer path from /authentification
require_once __DIR__ . '/../partials/footer.php';
?>
