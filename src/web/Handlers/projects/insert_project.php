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

function insert_project($name, $description, $visibility, $state){
	global $db;

	$sql = 'INSERT INTO projets (nom, description, flag_Prive, flag_Etat)
			VALUES (:name, :description, :visibility, :state)';
	
	$req = $db -> prepare($sql);
	$req -> execute(array(
		'name'=>$name,
		'description'=>$description,
		'visibility'=>$visibility,
		'state'=>$state));
	$last_id = $db->lastInsertId();
	$req->closeCursor();
	return $last_id;
}


?>


