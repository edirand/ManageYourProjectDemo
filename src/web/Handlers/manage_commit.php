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



function update_commit($project_id,$valeur,$id_num){
    global $db;

	$val = $valeur;
	if($val == ''){
		$sql = 'UPDATE UserStory
		SET commit_id= NULL
		WHERE projet_id="'.$project_id.'" AND numero="'.$id_num.'"'
		;
	}else{
		$sql = 'UPDATE UserStory
		SET commit_id="'.$val.'"
		WHERE projet_id="'.$project_id.'" AND numero="'.$id_num.'"'
		;
	}
    $req = $db -> prepare($sql);
    $res = $req -> execute();
	$today = date("Y-m-d H:i:s");
	$db->exec('Insert into Log(membre_id, element_modif, date_modif, projet_id) Value(' . $_SESSION['user_session'] . ', " a modifié la matrice de traçabilité", "'. $today . '", ' . $_SESSION['projet_id'] . ')');
    $req->closeCursor();
    return $res;
}



?>
