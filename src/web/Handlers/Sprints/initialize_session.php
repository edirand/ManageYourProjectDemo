<?php
	ini_set('display_errors','on');
	error_reporting(E_ALL);
	session_start();
	//On récupère le numéro de sprint
	try{
		$bdd = new PDO('mysql:host=localhost;dbname=MYP;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}
	$reponse = $bdd->query('Select count(*) from Sprints where projet_id =' . $_SESSION['projet_id']);
	
	$donnees = $reponse->fetch();
	$_SESSION['sprint_id'] = intval($donnees['count(*)']) + 1;
	$reponse->closeCursor();
	$bdd = null;

	require_once('tasks.php');
	$test = new listeTasks;
	$test->chargerEquipe($_SESSION['projet_id']);
	$test->chargerUsRestantes($_SESSION['projet_id']);
	$s = serialize($test);
	$_SESSION['taches'] = $s;
	header('Location: ../../Sprint.php');
	exit;
?>
