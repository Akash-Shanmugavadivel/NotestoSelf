<?php
session_start();
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reglog";

$conn = new mysqli($servername, $username, $password, $dbname);
if (!isset($_SESSION['id'])) {
  header("Location: login.php");
  exit();
}
$user_id = $_SESSION['id'];
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if the delete button is clicked
if (isset($_POST['delete'])) {
  $noteId = $_POST['noteId'];

  // Use prepared statement to delete the note from the database
  $stmt = $conn->prepare("DELETE FROM notes WHERE draw_id = ? AND user_id = ?");
  $stmt->bind_param("ii", $noteId, $user_id);
  $result = $stmt->execute();
  $stmt->close();

  if ($result) {
    echo "<script>alert('Note deleted successfully.')</script>";
  } else {
    echo "Error deleting note: " . $conn->error;
  }
}

// Retrieve all notes from the database
$sql = "SELECT * FROM notes WHERE user_id='$user_id'";
$result = $conn->query($sql);
$notes = array();
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $notes[] = $row;
  }
}
$conn->close();
?>

<!DOCTYPE html>
<style>
/* style.css */
body {
  font-family: Arial, sans-serif;
  line-height: 1.6;
  margin: 0;
  padding: 20px;
  background-color: #f9f9f9;
}

h1 {
  text-align: center;
  margin-bottom: 30px;
}

div.note {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  border: 1px solid #ddd;
  background-color: #fff;
  padding: 20px;
  margin-bottom: 20px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  border-radius: 5px;
}

h2 {
  font-size: 24px;
  margin-bottom: 10px;
  text-align: center; /* Center align the title */
}

img {
  max-width: 100%;
  height: auto;
  display: block;
  margin: 10px auto;
  border: 1px solid #ddd;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

button.delete-btn {
  background-color: #ff4d4d;
  color: #fff;
  border: none;
  padding: 8px 12px;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button.delete-btn:hover {
  background-color: #ff1a1a;
}

a.logout-btn {
  display: inline-block;
  background-color: #007bff;
  color: #fff;
  border: none;
  padding: 8px 12px;
  border-radius: 5px;
  text-decoration: none;
  margin-top: 10px;
  transition: background-color 0.3s ease;
}

a.logout-btn:hover {
  background-color: #0056b3;
}

/* Responsive styles */
@media screen and (max-width: 600px) {
  div.note {
    padding: 10px;
  }
}
  </style>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notes</title>
</head>
<body>
  <h1>Draw Notes</h1>
  <?php foreach ($notes as $note): ?>
    <div>
      <h2><?php echo $note['title']; ?></h2>
      <img src="<?php echo $note['drawing']; ?>" alt="Drawing">
      <form method="POST" action="">
        <input type="hidden" name="noteId" value="<?php echo $note['draw_id']; ?>">
        <button type="submit" name="delete">Delete</button>
      </form>
    </div>
  <?php endforeach; ?>
</body>
</html>
