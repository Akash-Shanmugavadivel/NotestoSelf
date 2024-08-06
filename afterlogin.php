
<!DOCTYPE html>
<html>
<head>
  <title>Notes to Self - Home</title>
  <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/128/1001/1001371.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    /* Styling for the menu tab */
    .menu-tab {
      background-color: #333;
      color: #fff;
      padding: 10px;
      cursor: pointer;
      position: absolute;
      top: 30px;
      right: 30px;
    }

    /* Styling for the side menu */
    .side-menu {
      width: 200px;
      height: 100%;
      background-color: #f2f2f2;
      position: fixed;
      float:right;
      top: 0;
      left: -200px;
      transition: left 0.3s ease;
    }

    /* Styling for the menu items */
    .side-menu ul {
      list-style: none;
      padding: 0;
    }

    .side-menu li {
      padding: 10px;
    }

    /* Show the side menu when its active */
    .side-menu.active {
      left: 0;
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
   .side-menu a:link,.side-menu a:visited {
  width:160px;
  background-color: #f44336;
  color: white;
  padding: 14px 25px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
}

.side-menu a:hover,.side-menu a:active {
  background-color: red;
}
* {
  box-sizing: border-box;
}

form.example input[type=text] {
  padding: 10px;
  font-size: 17px;
  border: 1px solid grey;
  float: left;
  width: 80%;
  background: #f1f1f1;
}

form.example button {
  float: left;
  width: 20%;
  padding: 10px;
  background: #2196F3;
  color: white;
  font-size: 17px;
  border: 1px solid grey;
  border-left: none;
  cursor: pointer;
}

form.example button:hover {
  background: #0b7dda;
}

form.example::after {
  content: "";
  clear: both;
  display: table;
}

form.example input[type=text] {
  padding: 10px;
  font-size: 17px;
  border: 1px solid grey;
  float: left;
  width: 80%;
  background: #f1f1f1;
}

form.example button {
  float: left;
  width: 20%;
  padding: 10px;
  background: black;
  color: white;
  font-size: 17px;
  border: 1px solid grey;
  border-left: none;
  cursor: pointer;
}

form.example button:hover {
  background: #0b7dda;
}

form.example::after {
  content: "";
  clear: both;
  display: table;
}
 .newnote-add{
  text-decoration: none;
  color:white;
  font-size: 18px;
  padding: 10px;
}
.newnote{
  position: absolute;
  top: 125px;
  right: 20px;
  
}
.newnote-btn:hover{
  background-color: rgb(1, 1, 100);
}
.newnote-btn{
  width: 150px;
  height: 45px;
  background-color:black;
  border: none;
  border-radius: 2px;
}
  </style>
</head>
<body>
  <div id="logo">
    <img src="https://media0.giphy.com/media/v1.Y2lkPTc5MGI3NjExZjhrYjEzbXI0N2xudnIxdm44N2VqNXRkOXoydnYxOTMweDZrczQ1MCZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9cw/hrixdHEyXD88TzFefp/giphy.gif" width="100px" height="75px">
    <div class="titlename">Notes to self</div>
    <div class="menu-tab" onclick="toggleSideMenu()">Menu</div>

  </div>
  
  <div class="side-menu" id="sideMenu">
    <ul>
    <li><a href="homepage.php">Home</a></li>
      <li><a href="chatsample.php">Notes</a></li>
      <li><a href="calender.php">Calendar</a></li>
      <li><a href="todo.php">Todo</a></li>
      <li><a href="draw.html">Draw</a></li>
      <li><a href="retrieve.php">View Draw</a></li>
      <li><a href="about.html">About</a></li>
      <li><a href="feedbackform.html">Feedback</a></li>
    </ul>
  </div>
   

  <br><br>
  <center>
  <div>
  <form class="example" action="/action_page.php" style="margin:auto;max-width:300px">
  <input type="text" placeholder="Search.." name="search2">
  <button type="submit"><i class="fa fa-search"></i></button>
</form>
<div class="newnote">
    <button class="newnote-btn"><a href="notestoself-title.html" class="newnote-add">New Notes</a></button>
</div>
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