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

if(isset($_POST['submit'])){

	$groupNaam	=  e($_POST['groupNaam']);
	$userID = $_SESSION['user']['id'] ;
	
	if (count($errors) == 0) {

			$query = "INSERT INTO grouped (groupNaam, userID) 
					  VALUES('$groupNaam', '$userID')";
			mysqli_query($db, $query);	
			
			header('location: group.php?id='. mysqli_insert_id($db) .'');			
	}

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

<form action='' method='post' enctype="multipart/form-data">
		
		<p><label>Naam Groep</label><br />
		<input type='text' name='groupNaam' value=''></p>
		
		<p><input type='submit' name='submit' value='Submit'></p>

	</form>

</div>