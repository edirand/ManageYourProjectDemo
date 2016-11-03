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

function insert_US($number, $description, $cost, $priority,$project_id){
	global $db;

	$sql = 'INSERT INTO userstory (numero, description, effort, priorite, projet_id)
			VALUES (:number, :description, :cost,:priority,:project_id)';
	
	$req = $db -> prepare($sql);
	$req -> execute(array(
		'number'=>$number,
		'description'=>$description,
		'cost'=>$cost,
		'priority'=>$priority,
		'project_id'=>$project_id));
	$req->closeCursor();
}

?>