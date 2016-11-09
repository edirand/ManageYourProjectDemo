<?php
	session_start();
	if($_SESSION['user_session'] == 1){
		echo 'vous n\'avez pas les droits';
	}else{
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=MYP;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}catch (Exception $e)
		
		{
			die('Erreur : ' . $e->getMessage());
		}
		
		$reponse = $bdd->query('Select id from Membres where login = "' .$_POST['login'].'"');
		
		while ($donnees = $reponse->fetch())
		{
			$id = $donnees['id'];
		}
		
		$bdd->exec('Insert into Developpeurs(membre_id, projet_id) Value(' . $id . ',' . $_SESSION['projet_id'] . ')');
		
		$today = date("Y-m-d H:i:s");
		$bdd->exec('Insert into Log(membre_id, element_modif, date_modif, projet_id) Value(' . $_SESSION[user_session] . ', " a ajouté un membre à l\'équipe", "'. $today . '", ' . $_SESSION['projet_id'] . ')');
		
		echo 'Ce membre a bien été ajouté au projet';
		$reponse->closeCursor();
	}
	
	?>
