<?php
// delete_image.php

// Check if the image_id is sent via POST
if (isset($_POST["f_id"]) && !empty($_POST["f_id"])) {
    $image_id = $_POST["f_id"];

    // Include the database configuration file
    require 'config.php';

    // Prevent SQL injection
    $image_id = mysqli_real_escape_string($conn, $image_id);

    // Construct the DELETE query
    $delete_query = "DELETE FROM imageupload WHERE image_id = '$image_id'";

    // Execute the DELETE query
    if (mysqli_query($conn, $delete_query)) {
        // Image deleted successfully, you can also redirect back to the gallery page
        header("Location: showfile.php");
        exit;
    } else {
        // Error occurred while deleting the image
        die("Database query failed: " . mysqli_error($conn));
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Redirect back to the gallery page if the image_id is not provided
    header("Location: showfile.php");
    exit;
}
?>
