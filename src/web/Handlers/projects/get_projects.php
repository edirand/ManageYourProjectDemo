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

function get_projects($limit=1,$member_name){
	global $db;
	/* récupération de l'id du membre*/
	$sql = 'SELECT id		
			FROM membres 
			WHERE login="'.$member_name.'"';
	$req = $db -> prepare($sql);
	$req -> execute();	
	$member_id=$req->fetch();	
	
	/* récupération des id des projets associés au membre*/
	$sql = 'SELECT projet_id		
			FROM developpeurs 
			WHERE membre_id="'.$member_id['id'].'"';
	$req = $db -> prepare($sql);
	$req -> execute();	
	$id_projects_array = array();
	while($data=$req->fetch(PDO::FETCH_ASSOC))
	{	
		$id_projects_array[]=$data['projet_id'];
	}	
	
	$id_projects = implode(",",$id_projects_array);
	//return $id_projects;
	
	/* récupération des projets*/
	$projects = array();
	$sql = 'SELECT *		
			FROM projets WHERE id IN ('.$id_projects.')';
	
	$req = $db -> prepare($sql);
	$req -> execute();
	while($data=$req->fetch())
	{	
		$projects[]=$data;
	}
	$req->closeCursor();
	return $projects;	
	
}
/*
function get_projects($limit=1){
	global $db;
	$projects = array();
	$sql = 'SELECT *		
			FROM projets ';
	//$sql .=' ORDER BY datetime DESC LIMIT 0,'.$limit;
	$sql .=' LIMIT 0,'.$limit;
	$req = $db -> prepare($sql);
	$req -> execute();
	while($data=$req->fetch())
	{	
		$projects[]=$data;
	}
	$req->closeCursor();
	return $projects;	
}
*/



?>
