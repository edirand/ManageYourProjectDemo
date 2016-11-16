<?php
	ini_set('display_errors','on');
	error_reporting(E_ALL);
	session_start();
	require_once('tasks.php');
	$test = unserialize($_SESSION['taches']);
	$i = $_GET['id'];
	$_SESSION['taches'] = serialize($test);
	echo $test->getInfos($i);
	?>
