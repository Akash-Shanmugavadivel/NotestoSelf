<!DOCTYPE html>
<html>
<head>
  <title>Notes to Self - Home</title>
  <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/128/1001/1001371.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="samplehome.css">
</head>
<body>
  <div id="logo">
    <img src="https://media0.giphy.com/media/v1.Y2lkPTc5MGI3NjExZjhrYjEzbXI0N2xudnIxdm44N2VqNXRkOXoydnYxOTMweDZrczQ1MCZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9cw/hrixdHEyXD88TzFefp/giphy.gif" width="100px" height="75px">
    <div class="titlename">Notes to self</div>


  </div>

    <ul>
      <li><a href="samplehomephp">Home</a></li>
      <li><a href="notestitle.php">New Notes</a></li>
      <li><a href="chatsample.php">Chat Notes</a></li>
      <li><a href="calender.php">Calendar</a></li>
      <li><a href="todo.php">Todo</a></li>
      <li><a href="keepnotes.html">Keep Notes</a></li>
      <li><a href="draw.html">Draw</a></li>
      <li><a href="about.html">About</a></li>
      <li><a href="feedbackform.html">Feedback</a></li>
      <li><a href="#" onclick="document.getElementById('id01').style.display='block'">SignUp</a></li>
      <li><a href="login.php">LogIn</a></li>
    </ul>
    <div id="id01" class="modal">
        
       <form class="modal-content animate" action="action_signup.php" method="post" autocomplete="off" onsubmit="return validateForm()">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close">&times;</span>
    </div>

    <div class="container">
    <h1 style="text-align:center;">Registration</h1>
    <label for="name">Name : </label>
      <input type="text" name="name" id = "name" required value=""> <br>
     
      <label for="username">Username : </label>
      <input type="text" name="username" id = "username" required value=""> <br>
     
      <label for="email">Email : </label>
      <input type="email" name="email" id = "email" required value=""> <br>
     
      <label for="password">Password : </label>
      <input type="password" name="password" id = "password" required value=""> <br>
      
      <label for="confirmpassword">Confirm Password : </label>
      <input type="password" name="confirmpassword" id = "confirmpassword" required value=""> <br>

      <button type="submit" name="submit">Register</button>
    </div>
    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
    </div>
    <br><br>
        <p style="text-align:center;" >Already have a account?<br><a href="login.php">Login</a><p>
  </form>
 
</div>
  <br><br>
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