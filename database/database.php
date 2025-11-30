<?php
$host = 'localhost';
$username = 'jeanleyder';
$password = 'H@iti2003';
$database = 'socrate_tech_institute';

$connect = mysqli_connect($host,$username,$password,$database);

if(!$connect){
    die('Failed to connect to the Database:'.mysqli_connect_error());
}
?>