<?php
	session_start();
	$login = utf8_decode($_POST['name']);
	
	try{
		$bdd = new PDO('mysql:host=localhost;dbname=MYP;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}
	
	
	$reponse = $bdd->query('Select M.id, M.login, M.mail from Membres as M left join Developpeurs as D ON M.id = D.membre_id where M.login like "' . $login . '%" AND M.id not in (select membre_id from Developpeurs where projet_id = '.  $_SESSION['projet_id'] . ') AND M.id != 1;');
	
	echo '<div class = "collaborateurs">';
	
	while ($donnees = $reponse->fetch())
	{
		echo '<a href="#" onclick="ajouter(\''. $donnees['login']. '\', ' . $_SESSION['projet_id'] . ')">';
		echo '<div class="personne">';
		echo '<div class = "name"><h1>' . $donnees['login'] . '</h1>' ;
		echo '<div class = "footer">' . $donnees['mail'] . '</div></div>';
		echo '</div>';
		echo '</a>';
	}
	echo '</div>';
	$reponse->closeCursor();
	$bdd = null;
	
	?>
