<script src = "js/Projet-js.js"></script>
<?php
	session_start();
		
	try{
		$bdd = new PDO('mysql:host=localhost;dbname=MYP;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}
	
	$reponse = $bdd->query('select count(*) from sprints');
	$nbSprints = $reponse->fetch();
	
	$reponse = $bdd->query('Select * from sprints where projet_id =' .$_SESSION['projet_id'] .  ';');
	
	echo '<ul><a href="#" onclick = "descProjet(); changeColor(' . $nbSprints['count(*)'] . ', 0)"><li id ="projet">Le projet</li></a>';

	while ($donnees = $reponse->fetch())
	{
		echo '<a href="#" onclick = "descSprint(' . $donnees['id'] . ', ' . $_SESSION['user_session'] . '); ; changeColor(' . $nbSprints['count(*)'] . ',' . $donnees['numero'] . ')"><li id = "sprint'.$donnees['numero'].'">Sprint #'.$donnees['numero'].'</li></a>';

	}
	//Empêche la planification de sprint pour les visiteurs
	if ($_SESSION['user_session']!=1){
		echo '<a href="Handlers/Sprints/initialize_session.php"><img src = "Icons/add-sprint.png" height = "30px" width = "30px"></a>';}
	echo'</ul>';
	echo '<script>changeColor(' .$nbSprints['count(*)'] .', 0);</script>';
	$reponse->closeCursor();
	$bdd = null;
	
?>
