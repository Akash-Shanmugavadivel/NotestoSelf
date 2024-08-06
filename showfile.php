<?php
require 'config.php';
if(!empty($_SESSION["id"])){
  $user_id = $_SESSION["id"];
  $result = mysqli_query($conn, "SELECT * FROM imageupload WHERE user_id = '$user_id'");
  if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
  $row = mysqli_fetch_assoc($result);
}}
else{
  header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>show photos</title>
<style>
  .file-container{
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
  }
  .file-info {
    text-align: center;
    margin: 10px;
  }
</style>

<head>
  <style>
 
  </style>
</head>
<body>
<h2>Image</h2>
  <div>
  <div id="main">
   
        <div class="file-container">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <table class="file-info">
                    <tr>
                        <td>
                            <img src="<?php echo $row["image"]; ?>" width="400px" height="400px" style="text-align: center;"alt="" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <center><p style="text-align: center;"><?php echo $row["title"]; ?></p></center>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <center><p style="text-align: center;"><?php echo $row["des"]; ?></p></center>
                        </td>
                    </tr>
                </table>
            <?php } ?>
        </div>
        <table>
    </div>
</body>
</html>