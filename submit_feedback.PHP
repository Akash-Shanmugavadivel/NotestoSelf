<?php
session_start(); // Start the session

// Retrieve the feedback data from the form
$improvements = $_POST['improvements'];
$experience = $_POST['experience'];
$positives = $_POST['positives'];
$negatives = $_POST['negatives'];
$rating = $_POST['rating'];

// Validate and sanitize the data (you can add more validation if required)

// Connect to the database
$servername = "localhost";  // Replace with your server name
$username = "root";  // Replace with your database username
$password = "";  // Replace with your database password
$dbname = "reglog";  // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

if (isset($_POST['submitfb'])) {
    // Prepare and execute the SQL query to insert the feedback into the database
    $sql = "INSERT INTO feedback (user_id, improvements, experience, positives, negatives, rating)
            VALUES ('$user_id', '$improvements', '$experience', '$positives', '$negatives', '$rating')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Feedback successfully submitted!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();

?>
