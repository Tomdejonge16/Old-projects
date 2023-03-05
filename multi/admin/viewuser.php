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
			echo "</br><div> <a href='viewproject.php?id=" . $row["projectID"]. "'> " . $rowproject["postNaam"]. "</a>  Startdate:" . $row["startdate"]." Enddate:" . $row["enddate"]." Status:" . $row["status"]." 
				  Verander status: <select name='status[]'><option value='Working'>Working</option><option value='Paused'>Paused</option><option value='Complete'>Complete</option></select>
				  <input type='hidden' name='id[]' value='". $row["ID"] ."'> </div> ";
				
			}	
			echo"</br><input type='submit' name='submit' value='Submit'><br></div>
			</form>";
				
			if(isset($_POST['submit'])){
				$id = $_POST['id'];
				$i = 0;
				foreach($_POST['status'] as $value) {
					$asignid = $id[$i];
					$query = "UPDATE asigned
							  SET status ='$value'
							  WHERE ID=$asignid";
					mysqli_query($db, $query)  or die ("Fout bij updaten".mysqli_error($db));
					
					$i++;
				}
				header('location: viewuser.php?id=' . $userid);
			}
		}	
		
?>
</div>