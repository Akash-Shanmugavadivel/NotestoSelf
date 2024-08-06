<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $notesTitle = $_POST["notes-title"];
    $description = $_POST["descrip-tion"];

    require 'config.php';

    
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO notes_table (title, description,user_id) VALUES ('$notesTitle', '$description','$user_id')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
            alert('Notes successfully created');
            </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!doctype html>
<html>
<head>
    <title>New Notes</title>
    <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/128/1001/1001371.png">
    <link rel="stylesheet" href="notetitle.css">
    <style>
        input[type="submit"] {
        background-color: black;
        color: white;
        font-size: 18px;
        padding: 10px 4px;
        border: none;
        cursor: pointer;
        width: 100%;
    }
    a{
        text-decoration: none;
        color: white;
    }
        </style>
</head>
<body>

<div class="bg">
    <div class="input-container">
        <form method="POST" action="" autocomplete="off">
            <input type="text" name="notes-title" id="notes-title" required value="">
            <label for="notes-title" class="notes">- - - Notes to Self - - -</label>
            <div class="input-line"></div><br><br><br>
            <input type="text" name="descrip-tion" id="descrip-tion" required value="">
            <label for="descrip-tion">- - - - Description - - - -</label>
            <br><br>
            <input type="submit" value="Create" name="create">
        </form>
        <br><br>
        <button class="cnote"><a href="chatsample.php">Chat Note</button>
    </div>
</div>

</body>
</html>