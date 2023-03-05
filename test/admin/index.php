<?php
//include config
require_once('../includes/config.php');
require('../nav.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }

//show message from add / edit page
if(isset($_GET['delpost'])){ 

	$stmt = $db->prepare('DELETE FROM games WHERE game_ID = :game_ID') ;
	$stmt->execute(array(':game_ID' => $_GET['delpost']));

	header('Location: index.php?action=deleted');
	exit;
} 

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
</head>
<body>

	<div id="wrapper">

	<?php 
	//show message from add / edit page
	if(isset($_GET['action'])){ 
		echo '<h3>Post '.$_GET['action'].'.</h3>'; 
	} 
	?>

	<table>
	<?php
		try {
			$i=0;
			$stmt = $db->query("SELECT game_ID, postNaam, postJaar, postPlat, Foto FROM games WHERE memberID='". $_SESSION['memberID']."' ORDER BY game_ID DESC");
			echo '<tr style="height: 25%;">';
			while($row = $stmt->fetch()){
				
				echo '<td style="width:25%; height:250px; max-height:250px; text-align: center;" ><a href="viewpost.php?id=' . $row['game_ID']. '" style="display:block;">
				<img src="'. $row['Foto'].'" alt="No Image found" height="220px"></br></br>'
				. $row['postNaam'] ." ". $row['postJaar']  ."<br> ". $row['postPlat'] .
				'</a></td>';				
				$i=$i+1;
				if( $i==4){
					echo'</tr><tr>';
					$i=0;
				}
			}

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	</table>


</div>

</body>
</html>
