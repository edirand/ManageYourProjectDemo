<?php
	session_start();
		
		try{
		$bdd = new PDO('mysql:host=localhost;dbname=MYP;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}
	$reponse = $bdd->query('Select numero, description, effort, priorite, sprint_id from UserStory where projet_id =' .$_SESSION['projet_id'] .  ';');
	
	echo '<div class = "title">Backlog du projet</div>';
	echo '<div class = "back">';
	echo '<table id = "b">';
	echo '<tr id = "first"><td>US#</td><td>Description</td><td>Effort</td><td>Priorité</td><td>Sprint</td></tr>';
	while ($donnees = $reponse->fetch())
	{
		$id = '';
		if(!empty($donnees['sprint_id'])){
			$reponse2 = $bdd->query('Select numero from Sprints where id =' .$donnees['sprint_id'] .  ';');
			$numero = $reponse2->fetch();
			$id = $numero['numero'];
		 }
		echo '<tr>';
		echo '<td id = "numero">' . $donnees['numero'] . '</td>';
		echo '<td id = "description">' . $donnees['description'] . '</td>';
		echo '<td id = "effort">' . $donnees['effort'] . '</td>';
		echo '<td id = "priorite">' . $donnees['priorite'] . '</td>';
		echo '<td id = "sprint">'. $id .'</td>';
		echo '</td>';
	}
	echo '</table></div>';
	$reponse2->closeCursor();
	$reponse->closeCursor();
	$bdd = null;
	
?>
