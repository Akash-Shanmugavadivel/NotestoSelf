<?php
require 'config.php';
if(!empty($_SESSION["id"])){
  $id = $_SESSION["id"];
  $result = mysqli_query($conn, "SELECT * FROM tb_user WHERE id = '$id'");
  $row = mysqli_fetch_assoc($result);
}
else{
  header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Notes to Self - Home loged in</title>
  <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/128/1001/1001371.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>

    .menu-tab {
      background-color: #333;
      color: #fff;
      padding: 10px;
      cursor: pointer;
      position: absolute;
      top: 30px;
      right: 30px;
    }

   ul {

      list-style: none;
      padding: 0;
      text-align: center;
      font-size: 16px;

    }

  li {
      padding: 10px;
      background-color:drakgrey;
      color: white;
      width: 95%;
      height: 100%;
      padding-right: 20px;
       display: inline-block;
       text-align: center;
    }
    .titlename{
      font-family: monospace;
      font-size: 35px;
      text-align:center;
      padding: 10px;
      color: white;
      padding-bottom: 20px;
      position: absolute;
      top: 15px;
      left: 40%;
    }
    #logo{
      padding: 10px;
      padding-left: 25px;
      background-color:black;
      width: auto;
      height: 80px;
    }
    img{
      padding-top: 4px;
      padding-bottom: 6px;
    }
  li a:link,li a:visited {
  width:65%;
  background-color: #000000;
  color: white;
  font-size: 20px;
  padding: 14px 25px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
}

li a:hover,li a:active {
  background-color: rgb(8, 8, 8);
}
* {
  box-sizing: border-box;
}

input {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

button {
  background-color: #000000;
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

li .name{
  color: white;
  background-color: black;
}



  </style>
</head>
<body>
  <div id="logo">
    <img src="https://media0.giphy.com/media/v1.Y2lkPTc5MGI3NjExZjhrYjEzbXI0N2xudnIxdm44N2VqNXRkOXoydnYxOTMweDZrczQ1MCZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9cw/hrixdHEyXD88TzFefp/giphy.gif" width="100px" height="75px">
    <div class="titlename">Notes to self</div>
    <div class="menu-tab" onclick="toggleSideMenu()">Menu</div>

  </div>
  
    <ul>
      <li class="name" style="color:black;"><a>Welcome <br><?php echo $row["name"];?><br><?php echo $row["email"];?><a></li>
      <li><a href="index.php">Home</a></li>
      <li><a href="notetitle.php">New Notes</a></li>
      <li><a href="chatsample.php">Chat Notes</a></li>
      <li><a href="calender.php">Calendar</a></li>
      <li><a href="todo.php">Todo</a></li>
      <li><a href="keepnotes.html">Keep Notes</a></li>
      <li><a href="draw.html">Draw</a></li>
      <li><a href="retrieve_note.php">View Draw</a></li>
      <li><a href="uploadphoto.php">Save Photo</a></li>
      <li><a href="showfile.php">Show Photo</a></li>
      <li><a href="remeinder.html">Remainder</a></li>
      <li><a href="audio.php">Record Audio</a></li>
      <li><a href="onenote.html">Basic text editor</a></li>
      <li><a href="about.html">About</a></li>
      <li><a href="feedbackform.html">Feedback</a></li>
      <li> <a href="logout.php">Logout</a></li>
      
    </ul>

  <br><br>
  <center>
  <div>
  </div>
</center>
  <script>
var modal = document.getElementById('id01');

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
    function toggleSideMenu() {
      var sideMenu = document.getElementById('sideMenu');
      sideMenu.classList.toggle('active');
    }
  </script>
  </body>
</html>
