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

function get_logs(){
	global $db;
	$logs = array();
	$sql = 'SELECT 	log.element_modif, log.date_modif, membres.login as member_name,
					projets.nom as project_name 		
			FROM log 
			LEFT JOIN membres ON log.membre_id = membres.id 
			LEFT JOIN projets ON log.projet_id = projets.id
			ORDER BY log.date_modif DESC
			LIMIT 10';
	$req = $db -> prepare($sql);
	$req -> execute();
	while($data=$req->fetch())
	{	
		$logs[]=$data;
	}
	
	$req->closeCursor();
	return $logs;	
}


?>
