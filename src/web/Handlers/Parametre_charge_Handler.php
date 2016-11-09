<?php

	session_start();
	try{
		$bdd = new PDO('mysql:host=localhost;dbname=MYP;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}
	$reponse = $bdd->query('Select * from Projets where id =' . $_SESSION['projet_id'] . ';');
	
	$donnees = $reponse->fetch();
	$reponse->closeCursor();
	$bdd = null;
	$prive = $donnees['flag_Prive'];
	$etat =$donnees['flag_Etat'];
	$res = $prive . ',' . $etat;
	echo $res;
?>
