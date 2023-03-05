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
		$postDate	=  date('Y-m-d H:i:s');
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

		if (count($errors) == 0) {

			$query = "INSERT INTO projects (postNaam, postOpdr, postEisen, postGroep, postTijd, postKennis, postResult, postCont, postBron, postDate, memberID) 
					  VALUES('$postNaam', '$postOpdr', '$postEisen', '$postGroep', '$postTijd', '$postKennis', '$postResult', '$postCont', '$postBron', '$postDate', '$memberID')";
			mysqli_query($db, $query) ;

			header('location: projects.php');				
		}
	}
					

	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo '<p class="error">'.$error.'</p>';
		}
	}
	
	?>
	<form action='' method='post' enctype="multipart/form-data">
		
		<p><label>Title</label><br />
		<input type='text' name='postNaam' value='<?php if(isset($error)){ echo $_POST['postNaam'];}?>'></p>
		
		<p><label>Opdracht</label><br />
		<input type='text' name='postOpdr' value='<?php if(isset($error)){ echo $_POST['postOpdr'];}?>'></p>
		
		<p><label>Eisen</label><br />
		<input type='text' name='postEisen' value='<?php if(isset($error)){ echo $_POST['postEisen'];}?>'></p>
		
		<p><label>Groepssamenstelling</label><br />
		<input type='text' name='postGroep' value='<?php if(isset($error)){ echo $_POST['postGroep'];}?>'></p>
		
		<p><label>Beschikbare tijd</label><br />
		<input type='text' name='postTijd' value='<?php if(isset($error)){ echo $_POST['postTijd'];}?>'>Weken</p>
		
		<p><label>Voorkennis</label><br />
		<input type='text' name='postKennis' value='<?php if(isset($error)){ echo $_POST['postKennis'];}?>'></p>
		
		<p><label>Situatie</label><br />
		<textarea name='postCont' cols='60' rows='2'><?php if(isset($error)){ echo $_POST['postCont'];}?></textarea></p>
		
		<p><label>Resultaat</label><br />
		<input type='text' name='postResult' value='<?php if(isset($error)){ echo $_POST['postResult'];}?>'></p>
		
		<p><label>Bronnen</label><br />
		<input type='text' name='postBron' value='<?php if(isset($error)){ echo $_POST['postBron'];}?>'></p>
			
		<p><input type='submit' name='submit' value='Submit'></p>

	</form>

</div>