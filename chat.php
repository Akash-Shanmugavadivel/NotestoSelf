<?php
// Database connection configuration
require 'config.php';
// Set the timezone
date_default_timezone_set("Asia/Kolkata"); // e.g., "Asia/Kolkata", "America/New_York"

// Check the connection
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

// Insert chat message into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["note"]) && !empty($_POST["note"])) {
        $note = sanitizeInput($_POST["note"]);
        $timestamp = date("Y-m-d H:i:s");
        
        // Retrieve the most recent notes title from the database
$sql = "SELECT note_id,title FROM notes_table ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $noteId= $row["note_id"];
}

         $sql = "INSERT INTO chat_messages (message, timestamp, note_id) VALUES ('$note', '$timestamp', '$noteId')";

        if ($conn->query($sql) === true) {
            // Message successfully inserted into the database
            header("Location: ".$_SERVER['PHP_SELF']); // Redirect to avoid duplicate form submissions
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
        header("Location: ".$_SERVER['PHP_SELF']); // Redirect to avoid duplicate form submissions
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

    $sql = "UPDATE chat_messages SET message = '$newMessage', timestamp = '$timestamp' WHERE id = '$messageId'";
    if ($conn->query($sql) === true) {
        // Message successfully edited in the database
        header("Location: ".$_SERVER['PHP_SELF']); // Redirect to avoid duplicate form submissions
        exit;
    } else {
        // Error editing the message
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Retrieve chat messages from the database
$sql = "SELECT cm.message_id, cm.message, cm.timestamp, nt.title 
        FROM chat_messages cm
        LEFT JOIN notes_table nt ON cm.note_id = nt.note_id
        ORDER BY cm.timestamp ASC";

$result = $conn->query($sql);
$messages = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $message = array(
            "id" => $row["message_id"],
            "message" => $row["message"],
            "timestamp" => $row["timestamp"],
            "title" => $row["title"] // Add the "title" field to the message array
        );
        $messages[] = $message;
    }
}


// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Notes to Self</title>
    <link rel="stylesheet" href="chat.css">
    <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/128/1001/1001371.png">
</head>
<body class="dark-mode">
    <div class="container">
        <h1 class="header">Notes to Self</h1>
        
        <!--<div class="note-title"><?php //echo $message['title']; ?></div>-->
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
                <textarea id="note" name="note" placeholder="Type your note here" oninput="resizeTextarea(this)"></textarea>
                <button class="sendnote">Send</button>
            </form>
        </div>
        <button class="theme" onclick="toggleTheme()">Theme</button>
        <button class="print-button" onclick="printChat()">Print</button>
    </div>

    <script>
        function toggleTheme() {
            var body = document.querySelector('body');
            body.classList.toggle('light-mode');
            body.classList.toggle('dark-mode');
        }

        function resizeTextarea(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = (textarea.scrollHeight + 1) + 'px';
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
                            // Message successfully edited in the database
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
    var chatPrint = chatBox.cloneNode(true); // Clone the chat box

    // Remove the actions (delete, edit, copy) buttons from the cloned chat box
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
</body>
</html>
