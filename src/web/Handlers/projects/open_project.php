<?php
	session_start();
	try
	{
		$db = new PDO('mysql:host=localhost; dbname=myp; charset=utf8', 'root','');
	}
	catch(Exception $e)
	{
		die('Erreur : ' . $e.getMessage());
	}
	
	$name =$_GET['title'];
	$reponse = $db->query('Select id from Projets where nom="' . $name . '";');
	
	$donnees = $reponse->fetch();
	$_SESSION['projet_id'] = $donnees['id'];
	$_SESSION['projet_nom'] = $name;
	echo "<script>top.location.href='mise_a_jour_retards.php';</script>";
?>

