<?php
	ini_set('display_errors','on');
	error_reporting(E_ALL);
	session_start();
	$taches = unserialize($_SESSION['taches']);
	$taches->supprimerAll();
	$_SESSION['taches'] = serialize($taches);
	try{
		$bdd = new PDO('mysql:host=localhost;dbname=MYP;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}
	$today = date("Y-m-d H:i:s");
	$bdd->exec('Insert into Log(membre_id, element_modif, date_modif, projet_id) Value(' . $_SESSION['user_session'] . ', " a planifié un nouveau sprint.", "'. $today . '", ' . $_SESSION['projet_id'] . ')');

?>
