<?php
	ini_set('display_errors','on');
	error_reporting(E_ALL);
	session_start();
	require_once 'backlog.php';

	$back = unserialize($_SESSION['backlog']);
	$back->modifierUs($_POST['id'], $_POST['desc'], $_POST['prio'], $_POST['eff']);
	try{
		$bdd = new PDO('mysql:host=localhost;dbname=MYP;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}
	$today = date("Y-m-d H:i:s");
	$bdd->exec('Insert into Log(membre_id, element_modif, date_modif, projet_id) Value(' . $_SESSION['user_session'] . ', " a modifié une US du backlog.", "'. $today . '", ' . $_SESSION['projet_id'] . ')');
?>
