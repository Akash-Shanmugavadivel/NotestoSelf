<?php
// Connect to the MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "akash";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// API endpoints
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Retrieve all notes
    $sql = "SELECT * FROM notes";
    $result = $conn->query($sql);
    $notes = array();
    while ($row = $result->fetch_assoc()) {
        $notes[] = $row;
    }
    echo json_encode($notes);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add a new note
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = date('Y-m-d H:i:s');
    
    $sql = "INSERT INTO notes (title, description, date) VALUES ('$title', '$description', '$date')";
    $result = $conn->query($sql);
    if ($result) {
        echo json_encode(array('status' => 'success'));
    } else {
        echo json_encode(array('status' => 'error'));
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Update an existing note
    parse_str(file_get_contents("php://input"), $putVars);
    $id = $putVars['id'];
    $title = $putVars['title'];
    $description = $putVars['description'];
    
    $sql = "UPDATE notes SET title='$title', description='$description' WHERE id='$id'";
    $result = $conn->query($sql);
    if ($result) {
        echo json_encode(array('status' => 'success'));
    } else {
        echo json_encode(array('status' => 'error'));
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Delete a note
    parse_str(file_get_contents("php://input"), $deleteVars);
    $id = $deleteVars['id'];
    
    $sql = "DELETE FROM notes WHERE id='$id'";
    $result = $conn->query($sql);
    if ($result) {
        echo json_encode(array('status' => 'success'));
    } else {
        echo json_encode(array('status' => 'error'));
    }
}

$conn->close();
?>
