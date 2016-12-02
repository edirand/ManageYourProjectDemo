<?php
	ini_set('display_errors','on');
	error_reporting(E_ALL);
	session_start();
	require_once('tasks.php');
	require_once('../tasks/tasks_requests.php');
	$test = unserialize($_SESSION['taches']);
	$debut = $_POST['debut'];


	//On créé un nouveau sprint
	try{
		$bdd = new PDO('mysql:host=localhost;dbname=MYP;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}

		$reponse2 = $bdd->query('Select temps_jours from projets where id = '. $_SESSION['projet_id']);
		$donnees2 = $reponse2->fetch();
		$nbrJours = $donnees2['temps_jours'];

	$fin = date('y-m-d', strtotime($debut. '+'.$nbrJours.' days'));

	$reponse = $bdd->exec('Insert into Sprints(numero, date_debut, date_fin, projet_id) Value(' . $_SESSION['sprint_id'] . ', "' . $debut . '", "' . $fin . '", ' . $_SESSION['projet_id'] . ')');

	//On récupère l'id du sprint créé
	$reponse = $bdd->query('Select id from Sprints where numero = ' . $_SESSION['sprint_id'] . ' and projet_id =' . $_SESSION['projet_id']);
	
	$donnees = $reponse->fetch();
	$id = $donnees['id'];
	$today = date("Y-m-d H:i:s");
	$bdd->exec('Insert into Log(membre_id, element_modif, date_modif, projet_id) Value(' . $_SESSION['user_session'] . ', " a planifié un nouveau sprint", "'. $today . '", ' . $_SESSION['projet_id'] . ')');
	$reponse->closeCursor();
	$bdd = null;
	
	$test->enregistrerAllTaches($id, $_SESSION['projet_id']);
	$test->enregistrerUsChoisies($id, $_SESSION['projet_id']);
	update_tasks_sl($_SESSION['projet_id']);
	
	//Enregistrement terminé, on passe au réinitialise
	//header('Location: reinitialize_session.php');
	//exit;
	?>
