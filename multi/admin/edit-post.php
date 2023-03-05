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

	//if form has been submitted process it
	if(isset($_POST['submit'])){

	global $db, $errors, $username, $email;
		$id = $_SESSION['user']['id'];
	// receive all input values from the form. Call the e() function
    // defined below to escape form values
		$postNaam	=  e($_POST['postNaam']);
		$postOpdr	=  e($_POST['postOpdr']);
		$postEisen	=  e($_POST['postEisen']);
		$postGroep	=  e($_POST['postGroep']);
		$postTijd	=  e($_POST['postTijd']);
		$postKennis	=  e($_POST['postKennis']);
		$postResult	=  e($_POST['postResult']);
		$postCont	=  e($_POST['postCont']);
		$postBron	=  e($_POST['postBron']);
		$memberID	=  $id;

		// form validation: ensure that the form is correctly filled
		/*if (empty($username)) { 
			array_push($errors, "Username is required"); 
		}
		if (empty($email)) { 
			array_push($errors, "Email is required"); 
		}
		if (empty($password_1)) { 
			array_push($errors, "Password is required"); 
		}
		if ($password_1 != $password_2) {
			array_push($errors, "The two passwords do not match");
		}
		*/	
		$projectid = $_GET['id'];
		if (count($errors) == 0) {

			$query = "UPDATE projects
					  SET postNaam='$postNaam', postOpdr='$postOpdr', postEisen='$postEisen', postGroep='$postGroep', postTijd='$postTijd', postKennis='$postKennis', postResult='$postResult', postCont='$postCont', postBron='$postBron', memberID='$memberID'
					  WHERE projectID =$projectid";
			mysqli_query($db, $query)  or die ("Fout bij updaten".mysqli_error($db));

			header('location: viewproject.php?id=' . $projectid);				
		}
	}
					

	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo '<p class="error">'.$error.'</p>';
		}
	}
	
	$projectid = $_GET['id'];
	$query = "SELECT * FROM projects WHERE projectID =". $projectid;
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc()
	
	?>
	<form action='' method='post' enctype="multipart/form-data">
		
		<p><label>Title</label><br />
		<input type='text' name='postNaam' value='<?php echo $row['postNaam'];?>'></p>
		
		<p><label>Opdracht</label><br />
		<input type='text' name='postOpdr' value='<?php echo $row['postOpdr'];?>'></p>
		
		<p><label>Eisen</label><br />
		<input type='text' name='postEisen' value='<?php echo $row['postEisen'];?>'></p>
		
		<p><label>Groepssamenstelling</label><br />
		<input type='text' name='postGroep' value='<?php echo $row['postGroep'];?>'></p>
		
		<p><label>Beschikbare tijd</label><br />
		<input type='text' name='postTijd' value='<?php echo $row['postTijd'];?>'></p>
		
		<p><label>Voorkennis</label><br />
		<input type='text' name='postKennis' value='<?php echo $row['postKennis'];?>'></p>
		
		<p><label>Situatie</label><br />
		<textarea name='postCont' cols='60' rows='2'><?php echo $row['postCont'];?></textarea></p>
		
		<p><label>Resultaat</label><br />
		<input type='text' name='postResult' value='<?php echo $row['postResult'];?>'></p>
		
		<p><label>Bronnen</label><br />
		<input type='text' name='postBron' value='<?php echo $row['postBron'];?>'></p>
			
		<p><input type='submit' name='submit' value='Submit'></p>

	</form>

</div>