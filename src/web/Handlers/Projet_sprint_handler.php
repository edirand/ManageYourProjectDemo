<?php
	session_start();
	
	ini_set('display_errors','on');
	error_reporting(E_ALL);

	
	require_once 'Sprints/tasks.php';
	
	$taches = new listeTasks;
	
	try{
		$bdd = new PDO('mysql:host=localhost;dbname=MYP;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}
	$reponse = $bdd->query('select date_debut, date_fin from Sprints where id = ' . $_POST['sprint_id'] .  ';');
	
	$donnees = $reponse->fetch();
	
	echo '<div class = "title">Backlog du Sprint</div>';
	echo '<div class = "dates"><div class = "date"><label for="debut">Date de début</label><input type="date" name="debut" id = "debut" value="' . $donnees['date_debut'] . '" disabled ></div><div class = "date"><label for="fin">Date de fin</label><input type="date" name="fin" id = "fin" value="' . $donnees['date_fin'] . '" disabled></div></div>';
	
	echo '<div class = "back">';
	echo '<table id = "b">';
	echo '<tr id = "first"><td>US#</td><td>Description</td><td>Effort</td><td>Priorité</td></tr>';
	
	
	$reponse = $bdd->query('Select numero, description, effort, priorite from UserStory where sprint_id = ' . $_POST['sprint_id'] .  ';');
	while ($donnees = $reponse->fetch())
	{
		echo '<tr>';
		echo '<td id = "numero">' . $donnees['numero'] . '</td>';
		echo '<td id = "description">' . $donnees['description'] . '</td>';
		echo '<td id = "effort">' . $donnees['effort'] . '</td>';
		echo '<td id = "priorite">' . $donnees['priorite'] . '</td>';
		echo '</td>';
	}
	echo '</table></div>';
	
	
	echo '<div class = "kanban">';
	echo '<table id = "k"><tr><th>TO DO</th><th>ON GOING</th><th>DONE</th></tr>';
	echo '<tr id="colonnes"><td id = "ToDo">';
	$taches->printTachesPostIt(0, $_POST['sprint_id']);
	echo '</td>';
	echo '<td id = "OnGoing">';
	$taches->printTachesPostIt(1, $_POST['sprint_id']);
	echo '</td>';
	echo '<td id = "Done">';
	$taches->printTachesPostIt(2, $_POST['sprint_id']);
	echo '</td></tr></table>';
	echo '</div>';
	echo '</div>';
	$reponse->closeCursor();
	$bdd = null;
	
?>
