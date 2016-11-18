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

function get_doc($project_id){
	global $db;
	
	$sql = 'SELECT *		
			FROM doc 
			WHERE projet_id="'.$project_id.'"';
	$req = $db -> prepare($sql);
	$req -> execute();	
	
	$res = $data=$req->fetch();
	
	$req->closeCursor();
	return $res;	
	
}

function update_doc($project_id,$addr_dev,$addr_demo,$tests,$tools,$vcs_rules,$quality_rules){
	global $db;	
	
	$sql = 'UPDATE Doc		
			SET adresse_dev="'.$addr_dev.'",
			adresse_demo = "'.$addr_demo.'",
			politique_tests= "'.$tests.'",
			langages_outils = "'.$tools.'",
			regles_depot="'.$vcs_rules.'",
			regles_qualite="'.$quality_rules.'" 			
			WHERE projet_id="'.$project_id.'"';
	$req = $db -> prepare($sql);
	$res = $req -> execute();
	$today = date("Y-m-d H:i:s");
	$db->exec('Insert into Log(membre_id, element_modif, date_modif, projet_id) Value(' . $_SESSION[user_session] . ', " a modifié la documentation du projet", "'. $today . '", ' . $_SESSION['projet_id'] . ')');
	$req->closeCursor();	
	return $res;
}



?>
