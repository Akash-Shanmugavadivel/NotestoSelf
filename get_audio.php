<?php
// Fetch audio records from the database (modify with your database details)
require 'config.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM audio_records";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $audioPath = $row["audio_path"];
        echo '<audio controls><source src="' . $audioPath . '" type="audio/webm"></audio><br>';
    }
} else {
    echo "No audio records found.";
}

$conn->close();
?>
