<?php 
include('../functions.php');
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
	$query = "SELECT * FROM users WHERE user_type='user' ";
	$result = mysqli_query($db, $query);
	if ($result != NULL) {
	  // output data of each row
	  while($row = $result->fetch_assoc()) {
		echo "<div><a href='viewuser.php?id=" . $row["id"]. "' style='display:block;'>  user: " . $row["username"]. "<br></div>";
	  }
	}
	echo '</br></br><button type="button"><a href="add-group.php">Create group</a></button>';
	?>
</div>