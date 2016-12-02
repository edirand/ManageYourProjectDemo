<?php
include_once "dep_graph.php";


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
	$sql = 'SELECT id,numero,date_debut		
			FROM sprints 
			WHERE projet_id="'.$project_id.'"';
	$req = $db -> prepare($sql);
	$req -> execute();	
	
	$sprints = array();
	$sprints_numbers = array();
	$sprints_starts = array();
	while($data=$req->fetch(PDO::FETCH_ASSOC))
	{	
		$sprints[]=$data['id'];
		$sprints_numbers[$data['id']] = $data['numero'];
		$sprints_starts[$data['id']] = $data['date_debut'];
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
	$res['starts'] = $sprints_starts;
	return $res;
	
}

function get_sprints_time($project_id){
	global $db;	
	$sql = 'SELECT temps_jours	
			FROM projets 
			WHERE id="'.$project_id.'"';
	$req = $db -> prepare($sql);
	$req -> execute();	
	$data=$req->fetch(PDO::FETCH_ASSOC);
	return $data['temps_jours'];
}

function req_update_task_sl($task_id,$soonest_start,$latest_end){
	global $db;	
	$sql = 'UPDATE taches	
			SET debut_tot="'.$soonest_start.'",
			fin_tard = "'.$latest_end.'"			 			
			WHERE id="'.$task_id.'"';
	$req = $db -> prepare($sql);
	$req -> execute();	
	$req->closeCursor();	
}

function update_tasks_sl($project_id){
	$sprints_array = get_sprints($project_id);	
	$sprints = $sprints_array['sprints'];
	$sprints_starts = $sprints_array['starts'];
	
	$sprint_time = get_sprints_time($project_id);	
	
	//echo count($sprints_array['sprints']);
	$gres = array();
	foreach($sprints as $ks=> $s){
		
		$dep = array();
		$cost = array();
		$numbers = array();
		$ids = array();
		$sprint_start;
		$sprint_id = -1;
		
		$tasks_number = 0;
		$sprint_start_date;
		
		foreach($s as $task){		
			$td = $task['dependances'];
			if(!empty($td) || $td== "0"){
				//$dep[] = explode(",",$td);					
				$dep[$task['numero']] = explode(",",$td);					
			}
			else {							
				//$dep[] = array();
				$dep[$task['numero']] = array();
			}
			//$cost[] = $task['cout'];	
			$cost[$task['numero']] = $task['cout'];	
			//the real number of the task
			$numbers[] = $task['numero'];
			//$ids[] = $task['id'];
			$ids[$task['numero']] = $task['id'];
			$sprint_start = $sprints_starts[$task['sprint_id']];
			
			if($sprint_id == -1) $sprint_id = $task['sprint_id'];
			++$tasks_number;					
		}		
		
		
		/*
		for($i = 0; $i < $tasks_number; ++$i){
			echo $numbers[$i].",";
		}
		*/
		
		
		
		$g = new GraphDep($tasks_number,$dep, $cost,$sprint_time);	
		$gres[$ks] = $g;
		
		//$g = new GraphDep($tasks_number,$number_dep, $number_cost,$sprint_time);			
		
		/*
		foreach($g->_dep as $d){
			foreach($d as $u){				
				echo $u.",";				
			}
			echo "<br>";
		}
		
		foreach($number_cost as $nc)
		echo $nc."<br>";
		echo "end cost <br>";
		*/
		$soonest_start = $g->get_soonest_start();
		$latest_end = $g->get_latest_end();
		
		/*
		echo "<br>test<br>";
		foreach($soonest_start as $ss){
			echo $ss.",";
		}
		echo "<br>";
		foreach($latest_end as $ss){
			echo $ss.",";
		}
		echo "<br>";
		echo "<br>";
		*/
		
		//for($i = 0; $i < $tasks_number; ++$i){			
		foreach($dep as $i => $v){
			$st = new DateTime($sprints_starts[$sprint_id]);
			$st_i = new DateInterval('P'.floor($soonest_start[$i]).'D');						
			$st->add($st_i);
			
			$le = new DateTime($sprints_starts[$sprint_id]);
			$le_i = new DateInterval('P'.floor($latest_end[$i]).'D');													
			$le->add($le_i);
			
			/*
			echo $st->format('Y-m-d');
			echo "<br>";
			echo $le->format('Y-m-d');;
			echo "<br><br>";
			*/
			req_update_task_sl($ids[$i],$st->format('Y-m-d'),$le->format('Y-m-d'));			
		}	
		
			
	}
	
	return $gres;
}

?>
