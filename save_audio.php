<?php
// Ensure this directory is writable by the web server
$uploadDir = "audio_uploads/";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["audio"])) {
    $file = $_FILES["audio"];

    if ($file["error"] === UPLOAD_ERR_OK) {
        $tmpName = $file["tmp_name"];
        $fileName = uniqid() . ".webm";
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($tmpName, $filePath)) {
            // Save the file information to the database (modify with your database details)
            require 'config.php';

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $audioName = $fileName;
            $audioPath = $filePath;

            $sql = "INSERT INTO audio_records (audio_name, audio_path) VALUES ('$audioName', '$audioPath')";

            if ($conn->query($sql) === TRUE) {
                $response = array("success" => true);
                echo json_encode($response);
            } else {
                $response = array("success" => false, "message" => "Error saving audio to database.");
                echo json_encode($response);
            }

            $conn->close();
        } else {
            $response = array("success" => false, "message" => "Error saving audio file.");
            echo json_encode($response);
        }
    } else {
        $response = array("success" => false, "message" => "Error uploading audio.");
        echo json_encode($response);
    }
}
?>
