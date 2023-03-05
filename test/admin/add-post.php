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
	print_r($user);

	//if form has been submitted process it
	if(isset($_POST['submit'])){

		$_POST = array_map( 'stripslashes', $_POST );

		//collect form data
		extract($_POST);

		//very basic validation
		if($postNaam ==''){
			$error[] = 'Naam kan niet leeg zijn.';
		}
		if($postJaar ==''){
			$error[] = 'Jaar kan niet leeg zijn.';
		}
		if($postPlat ==''){
			$error[] = 'Platform kan niet leeg zijn.';
		}
		
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

			try {

				//insert into database
				$stmt = $db->prepare('INSERT INTO games (postNaam,postJaar,postPlat,postDev,postUitg,postRegio,postVersie,postCont,postDate,memberID,Foto) VALUES (:postNaam, :postJaar, :postPlat, :postDev, :postUitg, :postRegio, :postVersie, :postCont, :postDate, :memberID, :Foto)') ;
				$stmt->execute(array(
					':postNaam' => $postNaam,
					':postJaar' => $postJaar,
					':postPlat' => $postPlat,
					':postDev' => $postDev,
					':postUitg' => $postUitg,
					':postRegio' => $postRegio,
					':postVersie' => $postVersie,
					':postCont' => $postCont,
					':postDate' => date('Y-m-d H:i:s'),
					':memberID' => $_SESSION['memberID'],
					':Foto' => $file_name
				));
				
				header('Location: index.php');
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
		
		<p><label>Game naam</label><br />
		<input type='text' name='postNaam' value='<?php if(isset($error)){ echo $_POST['postNaam'];}?>'></p>
		
		<p><label>Jaar van uitgave</label><br />
		<input type='text' name='postJaar' value='<?php if(isset($error)){ echo $_POST['postJaar'];}?>'></p>
		
		<p><label>Platform</label><br />
		<input type='text' name='postPlat' value='<?php if(isset($error)){ echo $_POST['postPlat'];}?>'></p>
		
		<p><label>Developer</label><br />
		<input type='text' name='postDev' value='<?php if(isset($error)){ echo $_POST['postDev'];}?>'></p>
		
		<p><label>Uitgever</label><br />
		<input type='text' name='postUitg' value='<?php if(isset($error)){ echo $_POST['postUitg'];}?>'></p>
		
		<p><label>Regio van uitgave</label><br />
		<input type='text' name='postRegio' value='<?php if(isset($error)){ echo $_POST['postRegio'];}?>'></p>
		
		<p><label>Versie</label><br />
		<input type='text' name='postVersie' value='<?php if(isset($error)){ echo $_POST['postVersie'];}?>'></p>
		
		<p><label>Overige informatie</label><br />
		<textarea name='postCont' cols='60' rows='2'><?php if(isset($error)){ echo $_POST['postCont'];}?></textarea></p>
		
		<input type="file" name="fileToUpload" id="fileToUpload">

		<p><input type='submit' name='submit' value='Submit'></p>

	</form>

</div>
