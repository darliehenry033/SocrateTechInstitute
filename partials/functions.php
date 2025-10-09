<?php
include 'database.php';

function is_user_logged_in(){
    return isset($_SESSION['username']) && $_SESSION['username'] === true;
}

function user_exists($connect,$username){
$sql = 'SELECT * FROM users WHERE username = ? LIMIT 1';
$stmt = mysqli_prepare($connect,$sql);
mysqli_stmt_bind_param($stmt,'s',$username);
mysqli_execute($stmt);
mysqli_stmt_store_result($stmt);

return mysqli_stmt_num_rows($stmt) > 0;
}

function redirect($location){
    header("Location: $location");
    exit;
}


?>