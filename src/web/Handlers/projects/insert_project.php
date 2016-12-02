<?php

if(!isset($db)){
	
	try
	{
		$db = new PDO('mysql:host=localhost; dbname=myp; charset=utf8', 'root','');
	}
	catch(Exception $e)
	{
		die('Erreur : ' . $e.getMessage());
	}
}

function insert_project($name, $description,$sprint_duration, $visibility, $state){
	global $db;

	$sql = 'INSERT INTO projets (nom, description, temps_jours, flag_Prive, flag_Etat)
			VALUES (:name, :description,:duration, :visibility, :state)';
	
	$req = $db -> prepare($sql);
	$req -> execute(array(
		'name'=>$name,
		'description'=>$description,
		'duration'=>$sprint_duration,
		'visibility'=>$visibility,
		'state'=>$state));
	$last_id = $db->lastInsertId();
	$req->closeCursor();
	return $last_id;
}


?>


