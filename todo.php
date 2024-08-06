<?php
require 'config.php';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

if (isset($_POST['Add'])) {
    $task = $_POST["task"];

    if (!empty($task)) {
        $sql = "INSERT INTO todo_list (task, completed, user_id) VALUES ('$task', 0, '$user_id')";
        $conn->query($sql);

        header("Location: " . $_SERVER["PHP_SELF"]);
        exit();
    }
}

if (isset($_GET['task']) && isset($_GET['action'])) {
    $task = $_GET["task"];
    $action = $_GET["action"];

    if (!empty($task)) {
        $sql = "SELECT user_id FROM todo_list WHERE task = '$task'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $taskOwner = $row["user_id"];

            if ($taskOwner == $user_id) {
                if ($action === "toggle") {
                    $sql = "UPDATE todo_list SET completed = NOT completed WHERE task = '$task'";
                    $conn->query($sql);
                } elseif ($action === "delete") {
                    $sql = "DELETE FROM todo_list WHERE task = '$task'";
                    $conn->query($sql);
                }
            }
        }

        header("Location: " . $_SERVER["PHP_SELF"]);
        exit();
    }
}

$sql = "SELECT task, completed FROM todo_list WHERE user_id = '$user_id'";
$result = $conn->query($sql);
$tasks = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $task = $row["task"];
        $completed = $row["completed"];
        $tasks[] = array("task" => $task, "completed" => $completed);
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="todo.css">
    
    <link rel="stylesheet" href="menu.css">

    <style>
        
    * {
        margin: 0;
        padding: 0;
        font-family: sans-serif;
        box-sizing: border-box;
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

    .container {
        width: 100%;
        min-height: 100vh;
        background-color:white;
        padding: 10px;
    }

    .todo-app {
        width: 100%;
        max-width: 540px;
        background-color: rgb(7, 7, 7);
        margin: 100px auto 20px;
        padding: 40px 30px 70px;
        border-radius: 10px;
    }

    .todo-app h2 {
        color: white;
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color:white;
        padding-left: 20px;
        margin-bottom: 20px;
        border-radius: 40px;
    }

    input {
        background-color: white;
        border: none;
        outline: none;
        padding: 10px;
        background: transparent;
        font-weight: 14px;
    }

input[type="submit"] {
        border: none;
        outline: none;
        padding: 16px 50px;

        background-color: white;
        color: rgb(110, 110, 110);
        font-size: 16px;
        cursor: pointer;
        border-radius: 40px;
    }

    button:hover {
        background-color:lightgrey;
        color: white;
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
      <li><a href="index.php">Home</a></li>
      <li><a href="chatsample.php">Chat Notes</a></li>
      <li><a href="calender.php">Calendar</a></li>
      <li><a href="todo.php">Todo</a></li>
      <li><a href="keepnotes.html">Keep Notes</a></li>
      <li><a href="draw.html">Draw</a></li>
      <li><a href="uploadphoto.php">Save Photo</a></li>
      <li><a href="retrieve_note.php">View Draw</a></li>
      <li><a href="about.html">About</a></li>
      <li><a href="feedbackform.html">Feedback</a></li>
      <li> <a href="logout.php">Logout</a></li>
    </ul>
  </div>
    <div class="container">
        <div class="todo-app">
            <h2>To Do List</h2>
            <div class="row">
                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <input type="text" name="task" id="input-box" placeholder="Add Your To Do">
                    <input type="submit" value="Add" name="Add">
                </form>
            </div>
            <div id="list-container">
                <ul>
                    <?php foreach ($tasks as $task): ?>
                        <li <?php if ($task["completed"] == 1) echo 'style="color:black; text-decoration: line-through; "'; ?>>
                            <a href="?task=<?php echo $task["task"]; ?>&action=toggle" style="text-decoration: none; color: white;"><?php echo $task["task"]; ?></a>
                            <a href="?task=<?php echo $task["task"]; ?>&action=delete" style="text-decoration: none; color:gray;">Delete</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</body>
<script >
     function toggleSideMenu() {
      var sideMenu = document.getElementById('sideMenu');
      sideMenu.classList.toggle('active');
    }
  </script>
</script>
</html>
