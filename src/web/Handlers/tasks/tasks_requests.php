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

function get_sprints_numbers($project_id){
	global $db;	
	$sql = 'SELECT id, numero
			FROM sprints 
			WHERE projet_id="'.$project_id.'"';
	$req = $db -> prepare($sql);
	$req -> execute();	
	
	$res = array();
	while($data=$req->fetch(PDO::FETCH_ASSOC))
	{	
		$res[$data['id']]=$data['numero'];
	}		
	return $res;
}

function get_tasks($project_id){
	global $db;	
	$sql = 'SELECT id		
			FROM sprints 
			WHERE projet_id="'.$project_id.'"';
	$req = $db -> prepare($sql);
	$req -> execute();	
	
	$res = array();
	while($data=$req->fetch(PDO::FETCH_ASSOC))
	{	
		$res[]=$data['id'];
	}		
	
	$sprints_ids = join(",",$res);
	
	$sql = 'SELECT * 
			FROM taches 
			WHERE sprint_id IN ('.$sprints_ids.')';			
	$req = $db -> prepare($sql);
	$req -> execute();		
	$tasks = array();
	
	while($data=$req->fetch(PDO::FETCH_ASSOC))
	{	
		$tasks[]=$data;		
	}		
	return $tasks;
	
}

function get_sprints($project_id){
	global $db;	
	$sql = 'SELECT id,numero		
			FROM sprints 
			WHERE projet_id="'.$project_id.'"';
	$req = $db -> prepare($sql);
	$req -> execute();	
	
	$sprints = array();
	$sprints_numbers = array();
	while($data=$req->fetch(PDO::FETCH_ASSOC))
	{	
		$sprints[]=$data['id'];
		$sprints_numbers[$data['id']] = $data['numero'];
	}		
	
	$sprints_ids = join(",",$sprints);
	
	$sql = 'SELECT * 
			FROM taches 
			WHERE sprint_id IN ('.$sprints_ids.')';			
	$req = $db -> prepare($sql);
	$req -> execute();		
	$sprints = array();
	
	while($data=$req->fetch(PDO::FETCH_ASSOC))
	{	
		$number = $sprints_numbers[$data['sprint_id']];
		$sprints[$number][]=$data;		
	}		
	
	$res = array();
	$res['numbers'] = $sprints_numbers;
	$res['sprints'] = $sprints;
	return $res;
	
}

?>
