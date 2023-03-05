<?php include('../functions.php') ;
require('../nav.php');

if (!isAdmin()) {
	$_SESSION['msg'] = "not admin";
	header('location: ../index.php');
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: ../login.php");
}

global $db, $username, $errors;

if(isset($_GET['delpost'])){ 

	$projectid = $_GET['delpost'];
	$query = "DELETE FROM projects WHERE projectID =". $projectid;
	$result = mysqli_query($db, $query);
	header('Location: projects.php?action=deleted');
	exit;
} 
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

	<?php
	if(isset($_GET['action'])){ 
		echo '<h3>Post '.$_GET['action'].'.</h3>'; 
	} 
	
	$id = $_SESSION['user']['id'];
	$query = "SELECT postNaam, projectID FROM projects ";
	$result = mysqli_query($db, $query);

	
	if ($result != NULL) {
	  // output data of each row
	  while($row = $result->fetch_assoc()) {
		echo "<div> <a href='viewproject.php?id=" . $row["projectID"]. "' style='display:block;'>Title: " . $row["postNaam"]. "<br></div>";
	  }
	}
	?>

</div>