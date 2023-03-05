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

if(isset($_GET['delpost'])){ 

	$groupid = $_GET['id'];
	$userid = $_GET['delpost'];
	$query = "DELETE FROM groupuser WHERE userID =". $userid ." AND groupID =" . $groupid;
	$result = mysqli_query($db, $query);
	header('Location: viewgroup.php?id='. $groupid);
	exit;
} 

global $db, $username, $errors;
$groupid = $_GET['id'];
$query = "SELECT * FROM grouped WHERE groupID =". $groupid;
$result = mysqli_query($db, $query);
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
  <script language="JavaScript" type="text/javascript">
  function delpost(id)
  {
	  if (confirm("Are you sure you want to delete "))
	  {
	  	window.location.href = 'viewgroup.php?delpost=' + id;
	  }
  }
  </script>
</head>
<body>

<?php
		while($row = $result->fetch_assoc()) {		
			echo '<div style="">';
			echo '<h1>'.$row['groupNaam'].'</h1>
			</div>';
		}
		$query = "SELECT * FROM groupuser WHERE groupID=" . $groupid;
		$result = mysqli_query($db, $query);
		if ($result != NULL) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				
			$query = "SELECT * FROM users WHERE id=". $row['userID'];
			$userResult = mysqli_query($db, $query);
			$rowproject = $userResult->fetch_assoc();
			echo "</br><div> <a href='viewuser.php?id=" . $row["userID"]. "'> " . $rowproject["username"]. "   </a><button type='button'><a href='viewgroup.php?id=" . $groupid. "&delpost=". $row['userID'] ."'>Delete</a></button>";
			}	
			
		}
		echo '</br></br><button type="button"><a href="group.php?id='. $groupid .'">Studenten toevoegen</a></button>';
		
		?>
			
			</div>