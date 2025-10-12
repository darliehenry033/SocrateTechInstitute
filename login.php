<?php
include 'database.php';
include 'partials/functions.php';
include 'partials/linkheader.php';

/* 
if(is_user_logged_in()){
  redirect('admindash.php');
  }


*/
  $username = $email = $password = $password_confirm = $role = "";
  $error = "";
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = isset($_POST['username']) ? mysqli_real_escape_string($connect, trim(strip_tags($_POST['username']))) : '';
    $password = isset($_POST['password']) ? mysqli_real_escape_string($connect, trim(strip_tags($_POST['password']))) : '';
    
  
    if(empty($username) ||  empty($password)){
      $error = "The fields cannot be empty";
    }else if(!user_exists($connect,$username)){
    $error = "Unknown Username. Please Register first before Login.";
    }
    
    else if(strlen($password) < 8){
      $error = "Password and Password Confirm should have at least 8 characters";
    }else{
      //Logic
      $sql = "SELECT user_id,username,password FROM users WHERE username = ? LIMIT 1";
      $stmt = mysqli_prepare($connect,$sql);
      mysqli_stmt_bind_param($stmt,'s',$username);
      
      //$result = mysqli_stmt_get_result($stmt); 
     
      if( !mysqli_stmt_execute($stmt)      /**$result && ($user = mysqli_fetch_assoc($result))*/){
          if(password_verify($password,$user['password'])){
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['logged_in'] = true;
            $_SESSION['role'] = $user['role'];
              
            $routes = [
          
              'parent' => 'parentdash.php',
              'teacher' => 'teacherdash.php',
              'student' => 'studentdash.php',
              'admin' => 'admindash.php'
            ];
    
            $target = $routes[$user['role']] ?? 'index.php'; 
            redirect("$target");
          }
          else{
            $error = "Invalid Username or Password";
          }
         
      }
      mysqli_stmt_close($stmt);
    }
  }
?>

<div class="login-container-overlay-bg">
    <div class="login-container">
      <div class="regislog-left">
        <a href="index.html"><img src="images/logowhite.png" alt=""></a>
        <h1>Login</h1>
      </div>
      <div class="regislog-right">
        <div class="closingIconLogin">
          <i class="fa-solid fa-xmark"></i>
        </div>
        
        <form action="" enctype="multipart/form-data" method="POST">
        <?php if($error):?>
          <div class="error_message" >
            <p style="color: red";><?php echo htmlspecialchars($error)?></p>
          </div>
          <?php endif;?>
        <input type="text" name = "username" placeholder="Votre Nom d'utilisateur: " class="email" value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
          <input type="password" name = "password" placeholder="Votre Mot-de-Passe: " class="password">
          <p><span>Ou</span><br>Login avec les réseaux sociaux</p>
          <div class="social-media">
            <span class="social-icon"><i class="fab fa-google"></i></span>
            <span class="social-icon"><i class="fab fa-facebook"></i></span>
            <span class="social-icon"><i class="fab fa-github"></i></span>
            <span class="social-icon"><i class="fas fa-link"></i></span>
          </div>          
            <button class="contact button button-register" type="submit">Login</button>  
        </form>
      </div>
    </div>
    </div>
</div>

