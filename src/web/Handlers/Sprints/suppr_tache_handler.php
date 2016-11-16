<?php
	ini_set('display_errors','on');
	error_reporting(E_ALL);
	session_start();
	require_once('tasks.php');
	$test = unserialize($_SESSION['taches']);
	$n = $_POST['id'];
	$test->supprimerTache($n);
	$_SESSION['taches'] = serialize($test);
	echo $test->printAllTachesPostIt();
	?>
