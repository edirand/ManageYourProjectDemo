<?php
	session_start();
	
	ini_set('display_errors','on');
	error_reporting(E_ALL);
	
	try{
		$bdd = new PDO('mysql:host=localhost;dbname=MYP;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}

	$bdd->exec('Update Taches Set etat = ' . $_POST['state'] . ' where id = '. $_POST['id'] . ' ;');
	
	$today = date("Y-m-d");
	if($_POST['state'] == 1){
		$bdd->exec('Update Taches Set date_debut = "' . $today . '" where id = '. $_POST['id'] . ' ;');
	}else if($_POST['state'] == 2){
		$bdd->exec('Update Taches Set date_fin = "' . $today . '" where id = '. $_POST['id'] . ' ;');
	}
	
	$bdd = null;
	
?>
