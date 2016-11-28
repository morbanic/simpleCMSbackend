<?
require_once('/home/u408050119/public_html/config.php');
header('Content-Type:text/html; charset=UTF-8');

//definitons of login and logout texts
$txt_login = '<form class="prijava" action="index.php" method="POST">
  <input type="text" name="username" placeholder="Username"><br>
  <input type="password" name="password" placeholder="Password"><br>
  <input type="submit" name="Login" value="Login" id="submit">
</form>';

$txt_logout = '<form method="POST" action="index.php"> <input type="hidden" name="logout" value=1 > <input type="submit" value="LOGOUT"> </form> ';

// form variables
$logout_value = $_POST['logout'];
$password_value = $_POST['password'];
$username_value = $_POST['username'];

$print_login = false;
$print_logout = false;

//start of sessions
session_start();

//postavljanje username i sifre za prijavu 
$username_password = array( 
  "123" => "admin" , 
  "321" => "nimda" 
  );
$username_password_key = array_search($username_value , $username_password) ;

//provjera dali su podaci za prijavu tocni
if($password_value == $username_password_key && $username_password_key!=""){
  $_SESSION['loggedin']=true;
}
else if(!isset($password_value)&&!isset($username_value) && $_SESSION['loggedin']) { $_SESSION['loggedin']=true; }
else  { $_SESSION['loggedin'] = false; }

//za odjavu
if($logout_value==1) { $_SESSION['loggedin']=false; }

//ako nije loggedin
if(!$_SESSION["loggedin"]) {
  $print_login = true;
}
//ako je loggedin
else if($_SESSION["loggedin"]){
  $print_logout = true;
}
//ako nije ni je
else {}

//  


?><!DOCTYPE html>
<html>

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="cleartype" content="on">
    <meta name="HandheldFriendly" content="true">
    <title>Administracija</title>
    <link rel="stylesheet" type="text/css" href="<?=WEB_DIR?>/styles/admin.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

  </head>
  <body>
  <h2>Admin board</h2>
 <?= ($print_logout ? $txt_logout : '') ?>
  	<hr></hr>
<?=($print_login ? $txt_login : '') ?>

<?php
if($_SESSION["loggedin"]){ // početak ifa za otvorenu i dozvoljenu sesiju #################################################
  

$pdo = new PDO('mysql:host=mysql.hostinger.hr;dbname=+++', '++++', '++++');

//za upis zapisa u BLOG
$upis_blog = new Content($pdo);
$upis_blog->setInsertTable('test_table');
$upis_blog->printInputForm();

$upis_blog->insertPOSTED($_POST[$upis_blog->insertTable]);



} // kraj if-a ako je session otvoren
?>


  </body>   
 </html>