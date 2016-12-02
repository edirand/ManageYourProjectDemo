<?php
	ini_set('display_errors','on');
	error_reporting(E_ALL);
	require_once 'backlog.php';
	session_start();
	$back = new backlog;
	echo $back->printBacklog($_SESSION['projet_id']);
	$_SESSION['backlog'] = serialize($back);
	
?>
