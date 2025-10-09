<?php
if(is_user_logged_in()){
  redirect('admindash.php');
  }
  
  $username = $email = $password = $password_confirm = $role = "";
  $error = "";
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = isset($_POST['username']) ? mysqli_real_escape_string($connect, trim(strip_tags($_POST['username']))) : '';
    $password = isset($_POST['password']) ? mysqli_real_escape_string($connect, trim(strip_tags($_POST['password']))) : '';
    
  
    if(empty($username) ||  empty($password)){
      $error = "The fields cannot be empty";
    }else if(user_exists($connect,$username)){
    $error = "Username already exists. Please pick another one.";
    }
    
    else if(strlen($password) < 8){
      $error = "Password and Password Confirm should have at least 8 characters";
    }else{
      //Logic
      $sql = "SELECT username,password FROM users WHERE user_id = ? LIMIT 1";
      $stmt = mysqli_prepare($connect,$sql);
      mysqli_stmt_bind_param($stmt,'ss',$username,$password);
      $result = mysqli_stmt_get_result($connect,$stmt);
      if($result && ($user = mysqli_fetch_assoc($result))){
          if(password_verify($password,$user['password'])){
            $_SESSION['username'] = $username;
           $_SESSION['logged_in'] = true;
           redirect('admindash.php');
          }
          else{
            $error = "Invalid Username or Password";
          }
         
      }else{
          $error = "Failed to insert data from our DB caused of this error".$error;
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
        <input type="email" placeholder="Votre Email: " class="email" value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
          <input type="password" placeholder="Votre Mot-de-Passe: " class="password" value ="<?= isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '' ?>">
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

