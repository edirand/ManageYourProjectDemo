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

/*Only use this functio when creating a new project->no verifications*/
function insert_repositories($project_id,$dev,$demo){
	global $db;

	$sql = 'INSERT INTO doc (adresse_dev,adresse_demo,projet_id)
			VALUES (:dev,:demo,:project_id)';
	
	$req = $db -> prepare($sql);
	$req -> execute(array(
		'dev'=>$dev,	
		'demo'=>$demo,
		'project_id'=>$project_id));
	$req->closeCursor();
}

?>
