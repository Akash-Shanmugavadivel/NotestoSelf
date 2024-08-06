<!doctype html>
<html>
<head>
	<title>Upload Photo/Image</title>
	<style>
			body {
			font-family: Arial, sans-serif;
			background-color: #f0f0f0;
		}
		center {
			margin-top: 50px;
		}
		form {
			border: 1px solid #ccc;
			padding: 20px;
			border-radius: 5px;
			width: 400px;
			background-color: #fff;
		}
		label {
			font-weight: bold;
		}
		input[type="text"],
		input[type="file"] {
			width: 100%;
			padding: 10px;
			margin: 5px 0;
			border: 1px solid #ccc;
			border-radius: 4px;
		}
		input[type="submit"] {
			background-color: black;
			color: #fff;
			border: none;
			padding: 12px 20px;
			margin-top: 10px;
			border-radius: 4px;
			cursor: pointer;
		}
		input[type="submit"]:hover {
			background-color: grey;
		}
	</style>
</head>
<body>


</head>
<body>
	<center>
		<form action="" method="post" enctype="multipart/form-data">
		<label>Choose an Photo/Audio:</label><br>
		<input type="file" name="image" id="image" required/><br>
		<label>title:</label><br>
		<input type="text" name="title" id="title" required /><br>
    <label>Description</label>
    <input type="text" name="des" id="des"><br>
		<input type="submit" name="upload" value="Upload Data" required /><br>
	</form>

	</center>
</body>
</html>
<?php
include ("config.php");
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];
if(isset($_POST['upload']))
{
	$targetDir = "image/";
	$filename = basename($_FILES["image"]["name"]);
	$targetFilePath = $targetDir . $filename;
	$title = $_POST['title'];
  $des = $_POST['des'];
	if(move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)){
	$query = "insert into `imageupload`(`image`,`title`,`des`,`user_id`) values('$targetFilePath','$title','$des','$user_id')";
	$query_run = mysqli_query($conn,$query);
	}
	if($query_run)
	{
		echo '<script type="text/javascript"> alert("File Upload")</script>';
	} 
	else{

		echo '<script type="text/javascript"> alert("File Not Upload")</script>';

	}
}

