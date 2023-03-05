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

	$id = $_GET['id'];
	$userid = $_GET['delpost'];
	$query = "DELETE FROM asigned WHERE ID =". $userid;
	$result = mysqli_query($db, $query);
	header('Location: viewproject.php?id='. $id);
	exit;
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
  <script language="JavaScript" type="text/javascript">
  function delpost(id)
  {
	  if (confirm("Are you sure you want to delete "))
	  {
	  	window.location.href = 'projects.php?delpost=' + id;
	  }
  }
  </script>
</head>
<body>

<div id="wrapper">


<div>
	<?php
				
	
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
				echo '<p>Bronnen: '.$row['postBron'].'</p>
				</br><button type="button"><a href="edit-post.php?id='.$row['projectID'].'">Edit</a></button>
				<button type="button"><a href="javascript:delpost('. $row['projectID'] . ')">Delete</a></button>
				</br></br><button type="button"><a href="asign-user.php?id='.$row['projectID'].'">Asign users</a></button>
				</br></br><button type="button"><a href="asign-group.php?id='.$row['projectID'].'">Asign group</a></button>
				</div>';
		}
		
		$query = "SELECT * FROM asigned WHERE projectID=" . $projectid;
		$result = mysqli_query($db, $query);
		if ($result != NULL) {
			echo"<form action='' method='post'>";
			// output data of each row
				while($row = $result->fetch_assoc()) {
				$id = $_GET['id'];
				$query = "SELECT * FROM users WHERE id=". $row['userID'];
				$userResult = mysqli_query($db, $query);
				$rowuser = $userResult->fetch_assoc();
				echo "</br><div> User: " . $rowuser["username"]. "  Startdate:" . $row["startdate"]." Enddate:" . $row["enddate"]." Status:" . $row["status"]." 
					  Verander status: <select name='status[]'><option value='Working'>Working</option><option value='Paused'>Paused</option><option value='Complete'>Complete</option></select>
					  <input type='hidden' name='id[]' value='". $row["ID"] ."'> 
					  <button type='button'><a href='viewproject.php?id=" . $id . "&delpost=". $row['ID'] ."'>Delete</a></button></div> ";
				
				}	
				echo"<input type='submit' name='submit' value='Submit'><br></div>
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
					header('location: viewproject.php?id=' . $projectid);
				}
				
		}
		?>

	</div>

</div>