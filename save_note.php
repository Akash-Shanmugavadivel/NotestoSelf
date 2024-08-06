<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Retrieve the note data from the request
$data = json_decode(file_get_contents('php://input'), true);

// Extract the note title and drawing data
$noteTitle = $data['title'];
$drawingData = $data['drawing'];

// Check if the user is logged in
session_start();
if (!isset($_SESSION['id'])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['id'];

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reglog";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute the SQL statement to insert the note data into the database
$stmt = $conn->prepare("INSERT INTO notes (title, drawing, user_id) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $noteTitle, $drawingData, $user_id);
$result = $stmt->execute();
$stmt->close();

// Send the response back to the client
$response = ['success' => $result];
echo json_encode($response);

// Close the database connection
$conn->close();
?>
