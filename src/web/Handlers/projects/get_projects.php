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


?>