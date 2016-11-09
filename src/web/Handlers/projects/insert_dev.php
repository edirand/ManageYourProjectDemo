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

function insert_dev($member_name,$project_id){
	global $db;
	
	$sql = 'SELECT id		
			FROM membres 
			WHERE login="'.$member_name.'"';
	$req = $db -> prepare($sql);
	$req -> execute();	
	$member_id=$req->fetch();	
	
	$sql = 'INSERT INTO developpeurs (membre_id,projet_id)
			VALUES (:member_id,:project_id)';
	
	$req = $db -> prepare($sql);
	$req -> execute(array(
		'member_id'=>$member_id['id'],
		'project_id'=>$project_id));	
	$req->closeCursor();
	
	//$member_id['id']
}


?>


