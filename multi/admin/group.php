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

<?php
	
	$groupid = $_GET['id'];
	$query = "SELECT * FROM users WHERE user_type='user' ";
	$result = mysqli_query($db, $query);

	?><form method="post" action="">
	<?php
	if ($result != NULL) {
	  // output data of each row
	  while($row = $result->fetch_assoc()) {
		echo "<div> <input type='checkbox' name='users[]' value='". $row["id"] ."'> user: " . $row["username"]. "<br></div>";
	  }
	}
	
	?>
	<input type='submit' value='Submit' name='submit'>
	</form>
	<?php
	if(isset($_POST['submit'])){
		
		if(!empty($_POST['users'])) {
			
			foreach($_POST['users'] as $value){
				
				$query = "INSERT INTO groupuser (groupID, userID)
						  VALUES('$groupid', '$value')";
				mysqli_query($db, $query) ;
			}
			header('location: viewgroup.php?id=' . $groupid );
		}
	}
?>

