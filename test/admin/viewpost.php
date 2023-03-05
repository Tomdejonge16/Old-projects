<?php

require_once('../includes/config.php');
require('../nav.php');

$stmt = $db->prepare('SELECT  game_ID, postNaam, postJaar, postPlat, postDev, postUitg, postRegio, postVersie, postCont, memberID, Foto FROM games WHERE game_ID = :game_ID');
$stmt->execute(array(':game_ID' => $_GET['id']));
$row = $stmt->fetch();

//if post does not exists redirect user.
if($row['game_ID'] == ''){
	header('Location: ./');
	exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/main.css">
	  <script language="JavaScript" type="text/javascript">
  function delpost(id)
  {
	  if (confirm("Are you sure you want to delete "))
	  {
	  	window.location.href = 'index.php?delpost=' + id;
	  }
  }"/*, postOpdr='$postOpdr', postEisen='$postEisen', postGroep='$postGroep', postTijd='$postTijd', postKennis='$postKennis', postResult='$postResult', postCont='$postCont', postBron='$postBron', memberID='$memberID'*/"
  </script>
</head>
<body>

	<div>
		<?php	
			echo '<div style="text-align: center;">';
				echo '<h1>'.$row['postNaam'].'</h1>';
				echo '</br></br><table style="margin-left:35%; text-align: left; width: 100%;">
				<tr>
				<td style="width: 15%;"><img src="'. $row['Foto'].'" alt="no image found" height="250px" ></td>';
				echo '<td>
				<p>Jaar van Uitgave:'.$row['postJaar'].'</p>';
				echo '<p>Platform:'.$row['postPlat'].'</p>';	
				echo '<p>Developers:'.$row['postDev'].'</p>';	
				echo '<p>Uitgever:'.$row['postUitg'].'</p>';	
				echo '<p>Regio:'.$row['postRegio'].'</p>';	
				echo '<p>Versie:'.$row['postVersie'].'</p></td></tr>';	
				echo '<tr style="padding-left:200%;"><td></br><p><h4>Overige informatie:</h4>'.$row['postCont'].'</p></td></tr>
				<tr><td></br><button type="button"><a href="edit-post.php?id='.$row['game_ID'].'">Edit</a></button>
				<button type="button"><a href="javascript:delpost('. $row['game_ID'] . ')">Delete</a></button>	
				</table>';						
			echo '</div>';
		?>

	</div>

</body>
</html>