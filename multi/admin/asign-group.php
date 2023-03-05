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
	
	$currentuserID = $_SESSION['user']['id'];
	$projectid = $_GET['id'];
	$query = "SELECT postTijd FROM projects WHERE projectID=". $projectid;
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	$startDate	=  date('Y-m-d');
	$day = $row["postTijd"] * 7; 
	$endDate=date('Y-m-d', strtotime("+$day days"));
	$query = "SELECT * FROM grouped WHERE userID='". $currentuserID ."' ";
	$result = mysqli_query($db, $query);

	?><form method="post" action="">
	<?php
	if ($result != NULL) {
	  // output data of each row
	  while($row = $result->fetch_assoc()) {
		echo "<div> <input type='checkbox' name='group[]' value='". $row["groupID"] ."'> " . $row["groupNaam"]. "<br></div>";
	  }
	}
	
	echo "<input type='date' value='". $startDate ."' name='startDate'></br>";
	echo "<input type='date' value='". $endDate ."' name='endDate'></br>";
	?>
	<input type='submit' value='Submit' name='submit'>
	</form>
	<?php
	if(isset($_POST['submit'])){
		
		$startDate	=  e($_POST['startDate']);
		$endDate	=  e($_POST['endDate']);
		
		if(!empty($_POST['group'])) {
			
			foreach($_POST['group'] as $value){
				
				$query = "SELECT userID FROM groupuser WHERE groupID=" . $value;
				$result = mysqli_query($db, $query);
				if ($result != NULL) {
					// output data of each row
					while($row = $result->fetch_assoc()) {
						$userid = $row['userID'];	
						$query = "INSERT INTO asigned (projectID, userID, status, startdate, endDate)
								  VALUES('$projectid', '$userid', 'Working', '$startDate', '$endDate')";
						mysqli_query($db, $query) ;
					}
				}
			}
			header('location: viewproject.php?id=' . $projectid );
		}
	}
?>
<div>