<?php //include config
require_once('../includes/config.php');
require('../nav.php');


//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin - Edit Post</title>
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

		if($postNaam ==''){
			$error[] = 'Naam kan niet leeg zijn.';
		}
		if($postJaar ==''){
			$error[] = 'Jaar kan niet leeg zijn.';
		}
		if($postPlat ==''){
			$error[] = 'Platform kan niet leeg zijn.';
		}
		
		if(!isset($error)){
			echo $game_ID;
			try {

				//insert into database
				$stmt = $db->prepare('UPDATE games SET postNaam = :postNaam, postJaar = :postJaar, postPlat = :postPlat, postDev = :postDev, postUitg = :postUitg, postRegio = :postRegio, postVersie = :postVersie, postCont = :postCont WHERE game_ID = :game_ID') ;;
				$stmt->execute(array(
					':postNaam' => $postNaam,
					':postJaar' => $postJaar,
					':postPlat' => $postPlat,
					':postDev' => $postDev,
					':postUitg' => $postUitg,
					':postRegio' => $postRegio,
					':postVersie' => $postVersie,
					':postCont' => $postCont,
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
			echo $error.'<br />';
		}
	}

		try {

			$stmt = $db->prepare('SELECT game_ID, postNaam, postJaar, postPlat, postDev, postUitg, postRegio, postVersie, postCont FROM games WHERE game_ID = :game_ID') ;
			$stmt->execute(array(':game_ID' => $_GET['id']));
			$row = $stmt->fetch(); 

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}

	
	?>
	<form action='' method='post'>
		<input type='hidden' name='game_ID' value='<?php echo $row['game_ID'];?>'>
		
		<p><label>Game naam</label><br />
		<input type='text' name='postNaam' value='<?php echo $row['postNaam'];?>'></p>
		
		<p><label>Jaar van uitgave</label><br />
		<input type='text' name='postJaar' value='<?php echo $row['postJaar'];?>'></p>
		
		<p><label>Platform</label><br />
		<input type='text' name='postPlat' value='<?php  echo $row['postPlat'];?>'></p>
		
		<p><label>Developer</label><br />
		<input type='text' name='postDev' value='<?php  echo $row['postDev'];?>'></p>
		
		<p><label>Uitgever</label><br />
		<input type='text' name='postUitg' value='<?php echo $row['postUitg'];?>'></p>
		
		<p><label>Regio van uitgave</label><br />
		<input type='text' name='postRegio' value='<?php echo $row['postRegio'];?>'></p>
		
		<p><label>Versie</label><br />
		<input type='text' name='postVersie' value='<?php  echo $row['postVersie'];?>'></p>
		
		<p><label>Overige informatie</label><br />
		<textarea name='postCont' cols='60' rows='2'><?php echo $row['postCont'];?></textarea></p>
		
		<p><input type='submit' name='submit' value='Update'></p>

	</form>
	<?php
	echo'<button type="button"><a href="edit_foto.php?id='.$row['game_ID'].'">Edit cover foto</a></button>'
	?>
</div>
</body>
</html>	
