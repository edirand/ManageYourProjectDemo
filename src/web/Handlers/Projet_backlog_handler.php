<?php
	session_start();
		
		try{
		$bdd = new PDO('mysql:host=localhost;dbname=MYP;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}
	$reponse = $bdd->query('Select numero, description, effort, priorite from UserStory where projet_id =' .$_SESSION['projet_id'] .  ';');
	
	echo '<div class = "title">Backlog du projet</div>';
	echo '<table>';
	echo '<tr id = "first"><td>US#</td><td>Description</td><td>Effort</td><td>Priorité</td></tr>';
	while ($donnees = $reponse->fetch())
	{
		echo '<tr>';
		echo '<td id = "numero">' . $donnees['numero'] . '</td>';
		echo '<td id = "description">' . $donnees['description'] . '</td>';
		echo '<td id = "effort">' . $donnees['effort'] . '</td>';
		echo '<td id = "priorite">' . $donnees['priorite'] . '</td>';
		echo '</td>';
	}
	echo '</table>';
	$reponse->closeCursor();
	$bdd = null;
	
?>
