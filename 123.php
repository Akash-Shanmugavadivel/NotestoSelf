<?php
require 'config.php';
date_default_timezone_set("Asia/Kolkata");
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['id'];
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize user input
function sanitizeInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

// Retrieve available note titles from the database
$sql = "SELECT  title,note_id,user_id FROM notes_table WHERE user_id=$user_id";
$result = $conn->query($sql);
$noteTitles = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $noteTitle = array(
            "id" => $row["note_id"],
            "title" => $row["title"]
        );
        $noteTitles[] = $noteTitle;
    }
}

// Insert chat message into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["note"]) && !empty($_POST["note"])) {
        $note = sanitizeInput($_POST["note"]);
        $timestamp = date("Y-m-d H:i:s");
$selectedNoteId = isset($_POST['selected-note']) ? $_POST['selected-note'] : (isset($noteTitles[0]['id']) ? $noteTitles[0]['id'] : '');

        $sql = "INSERT INTO chat_messages (message, timestamp, note_id) VALUES ('$note', '$timestamp', '$selectedNoteId')";

        if ($conn->query($sql) === true) {
            // Message successfully inserted into the database
            header("Location: ".$_SERVER['PHP_SELF']); 
            exit;
        } else {
            // Error inserting the message
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Delete chat message from the database
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
    $messageId = $_POST["delete"];
    $sql = "DELETE FROM chat_messages WHERE message_id = '$messageId'";
    if ($conn->query($sql) === true) {
        // Message successfully deleted from the database
        header("Location: ".$_SERVER['PHP_SELF']); 
        exit;
    } else {
        // Error deleting the message
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Edit chat message in the database
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["messageId"]) && isset($_POST["newMessage"])) {
    $messageId = $_POST["messageId"];
    $newMessage = sanitizeInput($_POST["newMessage"]);
    $timestamp = date("Y-m-d H:i:s");

    $sql = "UPDATE chat_messages SET message = '$newMessage', timestamp = '$timestamp' WHERE message_id = '$messageId'";
    if ($conn->query($sql) === true) {
        // Message successfully edited in the database
        header("Location: ".$_SERVER['PHP_SELF']); 
        exit;
    } else {
        // Error editing the message
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Retrieve chat messages from the database for a specific selected notes title

$selectedNoteId = isset($_POST['selected-note']) ? $_POST['selected-note'] : '';

$sql = "SELECT cm.message_id, cm.message, cm.timestamp, nt.title 
        FROM chat_messages cm
        LEFT JOIN notes_table nt ON cm.note_id = nt.note_id
        WHERE nt.note_id = '$selectedNoteId'
        ORDER BY cm.timestamp ASC";

$result = $conn->query($sql);
$messages = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $message = array(
            "id" => $row["message_id"],
            "message" => $row["message"],
            "timestamp" => $row["timestamp"],
            "title" => $row["title"]
        );
        $messages[] = $message;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notes to Self</title>
    <link rel="stylesheet" href="chat.css">
    <link rel="stylesheet" href="menu.css">
    <style>
    .sendnote {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            margin-left: 10px;
        }

        .sendnote:hover {
            background-color: #0056b3;
        }

        /* Flexbox layout */
        .input-container {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .input-container select {
            flex: 1;
            margin-right: 10px;
        }

        .input-container textarea {
            flex: 2;
            resize: vertical;
            min-height: 40px;
            margin-right: 10px;
        }
        button{
            color:black;
        }
    </style>
    <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/128/1001/1001371.png">
</head>
<body class="dark-mode">
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
    <div class="container" style=" width: 800px;">
        <h1 class="header">Notes to Self</h1>
        
        <div class="chat-box" id="chatBox">
            <?php foreach ($messages as $message): ?>
                <div class="chat-message" data-message-id="<?php echo $message['id']; ?>" ondblclick="showActions(this)">
                    <div class="message-text"><?php echo $message['message']; ?></div>
                    <div class="time"><?php echo date("H:i", strtotime($message['timestamp'])); ?></div>
                    <div class="actions">
                        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" style="display: inline;">
                            <input type="hidden" name="delete" value="<?php echo $message['id']; ?>">
                            <button>Delete</button>
                        </form>
                        <button onclick="editMessage(<?php echo $message['id']; ?>, '<?php echo $message['message']; ?>')">Edit</button>
                        <button onclick="copyMessage('<?php echo $message['message']; ?>')">Copy</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="input-container">
            <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
               <select name="selected-note">
    <?php foreach ($noteTitles as $noteTitle): ?>
        <option value="<?php echo $noteTitle['id']; ?>" <?php echo ($selectedNoteId == $noteTitle['id']) ? 'selected' : ''; ?>><?php echo $noteTitle['title']; ?></option>
    <?php endforeach; ?>
</select>

                <input type="submit" value="select" name="select" >
                <br><br><br>
                <textarea id="note" name="note" placeholder="Type your note here" ></textarea>
                <button class="sendnote">Send</button>
            </form>
        </div>
        <div class="newnote">   
    <button class="toggle" onclick="toggleTheme()" style="color:white;">Theme</button><br><br>
    <button class="newnote-btn"><a href="notetitle.php" class="newnote-add">New Notes</a></button><br><br>
  <button class="print-button" onclick="printChat()" style="color:white;">Print</button>

    </div>
    </div>

    <script>
        function toggleTheme() {
            var body = document.querySelector('body');
            body.classList.toggle('light-mode');
            body.classList.toggle('dark-mode');
        }

   

        function showActions(chatMessage) {
            var actions = chatMessage.querySelector('.actions');
            actions.style.display = 'block';
        }

        function editMessage(messageId, currentMessage) {
            var newMessage = prompt("Edit the message:", currentMessage);
            if (newMessage !== null) {
                newMessage = newMessage.trim();
                if (newMessage !== '') {
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', '<?php echo $_SERVER["PHP_SELF"]; ?>', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            
                            var chatMessage = document.querySelector('.chat-message[data-message-id="' + messageId + '"]');
                            chatMessage.querySelector('.message-text').textContent = newMessage;
                            chatMessage.querySelector('.time').textContent = getCurrentTime();
                        }
                    };
                    xhr.send('messageId=' + encodeURIComponent(messageId) + '&newMessage=' + encodeURIComponent(newMessage));
                } else {
                    alert('Please enter a valid message.');
                }
            }
        }

        function copyMessage(message) {
            var textarea = document.createElement('textarea');
            textarea.value = message;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
            alert('Message copied to clipboard!');
        }

        function getCurrentTime() {
            var date = new Date();
            var hours = date.getHours().toString().padStart(2, '0');
            var minutes = date.getMinutes().toString().padStart(2, '0');
            return hours + ':' + minutes;
        }

        function printChat() {
            var chatBox = document.getElementById('chatBox');
            var chatPrint = chatBox.cloneNode(true);

            var actions = chatPrint.querySelectorAll('.actions');
            actions.forEach(function (action) {
                action.parentNode.removeChild(action);
            });

            var printWindow = window.open('', '_blank');
            printWindow.document.open();
            printWindow.document.write('<html><head><title>Print Chat</title></head><body>');
            printWindow.document.write('<div class="chat-box">' + chatPrint.innerHTML + '</div>');
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
    </script>
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
