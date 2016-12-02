<?php
	ini_set('display_errors','on');
	error_reporting(E_ALL);
	session_start();
	require_once('tasks.php');
	$test = unserialize($_SESSION['taches']);
	$n = $_POST['id'];
	$desc = $_POST['desc'];
	$cout = $_POST['cost'];
	$us = $_POST['us'];
	$dev = $_POST['dev'];
	$dep = $_POST['dep'];

	$test->modifierTache($n, $desc, $cout, 0, $us, $dep, $dev);
	$_SESSION['taches'] = serialize($test);
	echo $test->printAllTachesPostIt();
	?>
