<?php
require 'config.php';
if(!empty($_SESSION["id"])){
  header("Location: index.php");
}
if(isset($_POST["submit"])){
  $usernameemail = $_POST["usernameemail"];
  $password = $_POST["password"];
  $result = mysqli_query($conn, "SELECT * FROM tb_user WHERE username = '$usernameemail' OR email = '$usernameemail'");
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
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
<style>
    input{
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

/* Set a style for all buttons */
button {
  background-color:black;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

button:hover {
  opacity: 0.8;
}

.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: black;
}

.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
  position: relative;
}

.container {
  padding: 16px;
}
.modal-content {
  background-color: #fefefe;
  margin: 5% auto 15% auto; 
  border: 1px solid #888;
  width: 80%; 
}

.close {
  position: absolute;
  right: 25px;
  top: 0;
  color: #000;
  font-size: 35px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: red;
  cursor: pointer;
}

  </style>  
  </head>
  <body>
  <div id="id01" class="modal">
  <h1 style="text-align:center;">Login</h1>
    <form class="" action="" method="post" autocomplete="off">
    <div class="imgcontainer">
    <span onclick="window.location.href='homepage.php';" class="close" title="Close">&times;</span> 
</div>
<div class="container">
    <label for="usernameemail">Username or Email : </label>
      <input type="text" name="usernameemail" id = "usernameemail" required value="" autocomplete="off" > <br>
      <label for="password">Password : </label>
      <input type="password" name="password" id = "password" required value="" > <br>
      <button type="submit" name="submit">Login</button>
      </div>
      <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="window.location.href='homepage.php';" class="cancelbtn">Cancel</button>
    </div>
    <br><br>
        <p style="text-align:center;" >Already have a account?<a href="homepage.php">Registration</a></p>
    </form>
    </div>
    <br>
    
  </body>
</html>
