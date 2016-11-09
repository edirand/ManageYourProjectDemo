<?php session_start();
	?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">

<title> Dashboard </title>
<script src = "http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src = "js/Parametre-js.js"></script>
<link href="css/Parametres.css" rel="stylesheet" media="screen">
</head>

<body>

<form method="POST" action="Handlers/Parametre_save_handler.php">
	<div class = "contenu">
		<h1> Paramètres </h1>
		<div class = "param">
			<div class = "head">
				<img src ="Icons/sett.png" width = "30"/>
				<p>État du projet</p>
			</div>
			<div class = "corps">
				<input class = "check" type="checkbox" name="private" value="1" id = "private">Privé
			</div>
			<div class = "foot">
				Choisissez qui peut voir votre projet. Attention : un projet public est visible et modifiable par tous.
			</div>
			<div class = "corps">
				<input class = "check" type="checkbox" name="finished" value="1" id = "finished">Terminé
			</div>
			<div class = "foot">
				Lorsque votre projet est terminé, cochez cette case afin de l'archiver dans votre workspace.
			</div>
		</div>
		<div class = "param">
			<div class = "head">
				<img src ="Icons/warn.png" width = "30"/>
				<p>Attention</p>
			</div>
			<div class = "corps">
				<input class = "check" type="checkbox" name="delete" value="1" id = "delete">Supprimer
			</div>
			<div class = "foot">
				La suppression d'un projet est définitive.
			</div>
		</div>
		<input class = "bouton" type="submit" value="Valider" >
	</div>
</form>
</body>
</html>
