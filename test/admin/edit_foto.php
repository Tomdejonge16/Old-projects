<?php 

//include config
require_once('../includes/config.php');
require('../nav.php'); 

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }
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

		$_POST = array_map( 'stripslashes', $_POST );

		//collect form data
		extract($_POST);

		
		$file_name = 0;
		if($_FILES['fileToUpload']['size'] != 0){
			
			$target_dir = "uploads/";
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {
			  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			  if($check !== false) {
				$uploadOk = 1;
			  } else {
				$uploadOk = 0;
			  }
			}

			// Check file size
			if ($_FILES["fileToUpload"]["size"] > 500000) {
			  $uploadOk = 0;
			}

			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
			  $uploadOk = 0;
			}

			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
			// if everything is ok, try to upload file
			} else {
			  $file_name = $target_file . $_SESSION['memberID'] . date('Y-m-d-H-i-s') . ".png";
			  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $file_name )) {
			  } else {
				echo "Sorry, there was an error uploading your file.";
			  }
			}
		}
		
		if(!isset($error)){
			
			$game_ID = $_GET['id'];

			try {

				//insert into database
				$stmt = $db->prepare('UPDATE games SET Foto = :Foto  WHERE game_ID = :game_ID') ;
				$stmt->execute(array(

					':Foto' => $file_name,
					':game_ID' => $game_ID
					
				));
				
				header('Location: viewpost.php?id='.$game_ID.'');
				exit;
				
			} catch(PDOException $e) {
			    echo $e->getMessage();
			}

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
		
		
		<input type="file" name="fileToUpload" id="fileToUpload">

		<p><input type='submit' name='submit' value='Submit'></p>

	</form>
	
	

</div>
