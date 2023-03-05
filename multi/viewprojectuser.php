<?php 
	include('functions.php');
	
	if (!isLoggedIn()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: login.php');		
	}
	
	global $db, $username, $errors;
	$projectid = $_GET['id'];
	$query = "SELECT * FROM projects WHERE projectID =". $projectid;
	$result = mysqli_query($db, $query);
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
<body>
<div id="wrapper">
	<div>
	<?php
		echo '<a href="userviewuser.php?id='. $_SESSION['user']['id'] . '" style="color: red;">Terug naar profiel</a>' 	;
		while($row = $result->fetch_assoc()) {		
			echo '<div style="">';
				echo '<h1>'.$row['postNaam'].'</h1>';
				echo '<p>Opdracht: '.$row['postOpdr'].'</p>';
				echo '<p>Eisen: '.$row['postEisen'].'</p>';	
				echo '<p>Groepsamenstelling: '.$row['postGroep'].'</p>';	
				echo '<p>Beschikbare tijd: '.$row['postTijd'].'</p>';	
				echo '<p>Voorkennis: '.$row['postKennis'].'</p>';		
				echo '<p>Situatie: </br>'.$row['postCont'].'</p>';
				echo '<p>Resultaat: '.$row['postResult'].'</p>';
				echo '<p>Bronnen: '.$row['postBron'].'</p>;
				</div>';
		}		
	?>
	</div>
</div>