<?php
	ini_set('display_errors','on');
	error_reporting(E_ALL);
	session_start();
	require_once 'backlog.php';

	$back = unserialize($_SESSION['backlog']);
	//Affiche les infos d'une US pour la modifier
	echo $back->getInfos($_GET['id']);
?>
