<?php
require 'config.php';
if(!empty($_SESSION["id"])){
  header("Location: index.php");
}
if(isset($_POST["submit"])){
  $usernameemail = $_POST["usernameemail"];
  $password = $_POST["password"];
  $result = mysqli_query($conn, "SELECT * FROM data_user WHERE username = '$usernameemail' OR email = '$usernameemail'");
  $row = mysqli_fetch_assoc($result);
  if(mysqli_num_rows($result) > 0){
    if($password == $row['password']){
      $_SESSION["login"] = true;
      $_SESSION["id"] = $row["id"];
      header("Location: index.php");
    }
    else{
      echo
      "<script> alert('Wrong Password'); </script>";
    }
  }
  else{
    echo
    "<script> alert('User Not Registered'); </script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="styleLogin.css">
    <style>
    body {
        font-family: 'Poppins';
        font-size: 24px;
    }
    </style>
    <title>LnT Back End Project</title>
</head>
<body>
    <div class="grid">
        <form class="" action="" method="post" autocomplete="off">
            <div class="title">
                <p> LOGIN </p>
            </div>
            <div class="field">
                <label for="usernameemail">Username</label>
                <input class="tbsearchbar" type="text" name="usernameemail" id = "usernameemail" required value="" placeholder="Username or Email"> <br>
            </div>
            <div class="field">
                <label for="password">Password : </label>
                <input class="tbsearchbar" type="password" name="password" id = "password" required value="" placeholder="Password"> <br>
            </div>
            <div class="button">
                <br>
                <button type="submit" name="submit">Log In</button>
            </div>
            <div class="registration">
                <br>
                <p> Don't Have An Account?
                <a href="register.php">Register</a>
            </div>
        </form>
    </div>
</body>
</html>