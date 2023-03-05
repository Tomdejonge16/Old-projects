<?php 
include('functions.php');

if (!isLoggedIn()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: login.php');
}

if (!isUser()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: index.php');
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: ../login.php");
}

global $db, $username, $errors;
$userid = $_GET['id'];
$query = "SELECT * FROM users WHERE id =". $userid;
$result = mysqli_query($db, $query);
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
</head>
<body>

<div id="wrapper">

<a href="index.php?logout='1'" style="color: red;">logout</a>

<?php
		while($row = $result->fetch_assoc()) {		
			echo '<div style="">';
			echo '<h1>'.$row['username'].'</h1>';
			echo '<p>Email: '.$row['email'].'</p>
			</div>';
		}
		$query = "SELECT * FROM asigned WHERE userID=" . $userid;
		$result = mysqli_query($db, $query);
		if ($result != NULL) {
			echo"<form action='' method='post'>";
			// output data of each row
			while($row = $result->fetch_assoc()) {
				
			$query = "SELECT * FROM projects WHERE projectID=". $row['projectID'];
			$userResult = mysqli_query($db, $query);
			$rowproject = $userResult->fetch_assoc();
			echo "</br><div> <a href='viewprojectuser.php?id=" . $row["projectID"]. "'> " . $rowproject["postNaam"]. "</a>  Startdate:" . $row["startdate"]." Enddate:" . $row["enddate"]." Status:" . $row["status"]." ";
				
			}	
			
			echo"</form>";
				
			
		}	
		
?>
</div>