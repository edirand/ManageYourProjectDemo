<?php
	session_start();
	try{
		$bdd = new PDO('mysql:host=localhost;dbname=MYP;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}
	$reponse = $bdd->query('Select login, mail from Membres where id in (Select membre_id from Developpeurs where projet_id =' . $_SESSION['projet_id'] . ') Order by login;');
	
	echo '<div class = "collaborateurs">';
	
	while ($donnees = $reponse->fetch())
	{
		echo '<div class="personne">';
		echo '<div class = "name"><h1>' . $donnees['login'] . '</h1>' ;
		echo '<div class = "footer">' . $donnees['mail'] . '</div></div>';
		echo '<a href="#" onclick="supprimer(\''. $donnees['login']. '\')"><img src = "Icons/remove-user.png" alt= "Supprimer" height = "25px" width = "25px"/></a>';
		echo '</div>';
	}
	echo '</div>';
	$reponse->closeCursor();
	$bdd = null;
	
	?>
