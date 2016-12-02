<?php
	
	ini_set('display_errors','on');
	error_reporting(E_ALL);
	session_start();
	try
	{
		$db = new PDO('mysql:host=localhost; dbname=myp; charset=utf8', 'root','');
	}
	catch(Exception $e)
	{
		die('Erreur : ' . $e.getMessage());
	}
	
	//On récupère toutes les US du projet qui sont assignées à des sprints et qui n'ont pas encore été validées
	$reponse = $db->query('select * from UserStory where projet_id =' . $_SESSION['projet_id'] . ' and sprint_id is not null and commit_id is null;');
	
	$today = date('Y-m-d');
	
	//On stocke les sprints dans un tableau.
	$reponse2 = $db->query('Select * from Sprints where projet_id = ' . $_SESSION['projet_id']);
	$sprints = array();
	$i = 0;
	while($sprintInfo = $reponse2->fetch()){
		$sprint = array();
		array_push($sprint, $sprintInfo['id'], $sprintInfo['date_fin']);
		array_push($sprints, $sprint);
		$i++;
	}

	//On va vérifier les dates des sprints pour chaque US et si cette date est passée, on réassigne l'US dans un nouveau sprint
	while($USInfo = $reponse->fetch()){
		//On parcourt le tableau de sprints pour trouver le bon sprint
		for($i = 0; $i<count($sprints); $i++){
			//Quand on trouve le sprint on sauvegarde sa date de fin
			if($USInfo['sprint_id'] == $sprints[$i][0]){
				//Si la date de fin est passée, on va vérifier tous les sprints suivant
				$date = $sprints[$i][1];
				if(strtotime($today)>strtotime($date)){
					for($j = $i; $j<count($sprints); $j++){
						//On met à jour le retard. Si la date de ce sprint n'est pas dépassée, on sort de la boucle, sinon on verifie le suivant
						if(strtotime($today)<=strtotime($sprints[$j][1])){
							$db->exec('Update UserStory set sprint_id_retard = ' . $sprints[$j][0] . ' where id = ' . $USInfo['id']);
							$j = count($sprints);
						}else{
							//Si la date est inférieure, on met à jour le sprint retard et on continue
							if(strtotime($today)>strtotime($sprints[$j][1])){
								//si on est au dernier sprint on bloque l'US
								if(($j+1)==count($sprints)){
									$db->exec('Update UserStory set bloque = 1 where id = ' . $USInfo['id']);
								}
								$db->exec('Update UserStory set sprint_id_retard = ' . $sprints[$j][0] . ' where id = ' . $USInfo['id']);
							}
						}
					}
				}
			}
		}
	}
	echo "<script>top.location.href='../../Dashboard.php';</script>";
?>
