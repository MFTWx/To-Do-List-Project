<?php
require 'config.php';
if(!empty($_SESSION["id"])){
  header("Location: index.php");
}
if(isset($_POST["submit"])){
  $name = $_POST["name"];
  $username = $_POST["username"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $confirmpassword = $_POST["confirmpassword"];
  $duplicate = mysqli_query($conn, "SELECT * FROM data_user WHERE username = '$username' OR email = '$email'");
  if(mysqli_num_rows($duplicate) > 0){
    echo
    "<script> alert('Username or Email Has Already Taken'); </script>";
  }
  else{
    if($password == $confirmpassword){
      $query = "INSERT INTO data_user VALUES('','$name','$username','$email','$password')";
      mysqli_query($conn, $query);
      echo
      "<script> alert('Registration Successful'); </script>";
    }
    else{
      echo
      "<script> alert('Password Does Not Match'); </script>";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="utf-8">
<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
<link rel="stylesheet" href="styleRegis.css">
<style>
  body {
      font-family: 'Poppins';
      font-size: 24px;
  }
</style>
<title>Registration</title>
</head>
<body>
  <div class="grid">
    <form class="" action="" method="post" autocomplete="off">
      <div class="title">
        <p> Registration </p>
      </div>
      <div class="field">
        <label for="name">Name : </label>
        <input class="tbsearchbar" type="text" name="name" id = "name" required value="" placeholder= "Name"> <br>
      </div>
      <div class="field">
        <label for="username">Username : </label>
        <input class="tbsearchbar" type="text" name="username" id = "username" required value="" placeholder= "Username"> <br>
      </div>
      <div class="field">
        <label for="email">Email : </label>
        <input class="tbsearchbar" type="email" name="email" id = "email" required value="" placeholder= "E-mail"> <br>
      </div>
      <div class="field">
        <label for="password">Password : </label>
        <input class="tbsearchbar" type="password" name="password" id = "password" required value="" placeholder="Password"> <br>
      </div>
      <div class="field">
        <label for="confirmpassword">Confirm Password : </label>
        <input class="tbsearchbar" type="password" name="confirmpassword" id = "confirmpassword" required value="" placeholder="Confirm Password"> <br>
      </div>
      <div class="button">
        <br>
        <form action="login.php">
          <button type="submit" name="submit">Register</button>
        </form>
      </div>
      <div class="login">
        <p> Try Log In! 
        <a href="login.php">Login</a>
      </div>
    </form>
    
  </div>
</body>
</html>