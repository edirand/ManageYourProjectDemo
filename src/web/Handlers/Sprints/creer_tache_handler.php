<?php
	ini_set('display_errors','on');
	error_reporting(E_ALL);
	session_start();
	require_once('tasks.php');
	$test = unserialize($_SESSION['taches']);
	$desc = $_POST['desc'];
	$cout = $_POST['cost'];
	$us = $_POST['us'];
	$dev = $_POST['dev'];
	$dep = $_POST['dep'];
	$deb = $_POST['deb'];
	$fin = $_POST['fin'];

	$test->creerTache($desc, $cout, 0, $us, $dep, $dev, $deb, $fin);
	//On enregistre l'id de la dernière tache pour pas l'afficher dans la liste
	$_SESSION['taches'] = serialize($test);
	echo $test->printAllTachesPostIt();
	?>
