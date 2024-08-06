<?php
require 'config.php';

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "DELETE FROM audio_records";

if ($conn->query($sql) === TRUE) {
    echo "All audio records have been deleted.";
} else {
    echo "Error deleting audio records: " . $conn->error;
}

$conn->close();
?>
