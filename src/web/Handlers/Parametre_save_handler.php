<?php
	session_start();
	
	try{
		$bdd = new PDO('mysql:host=localhost;dbname=MYP;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}

	if(!empty($_POST['delete']))
	{
		if($bdd->query('Delete from Projets where id =' . $_SESSION['projet_id'] . ';') == true){
			echo "<script>top.location.href='../workspace.php';</script>";
			
			exit;
		}else{
			echo 'Erreur d\'insertion';
		}
	}else{
		$priv = 0;
		$fin = 0;
		if(!empty($_POST['private']))
		{
			$priv =  $_POST['private'];
		}
		if(!empty($_POST['finished']))
		{
			$fin =  $_POST['finished'];
		}
		if($bdd->query('Update projets set flag_Prive =' . $priv . ', flag_Etat = ' . $fin . ' where id =' . $_SESSION['projet_id'] . ';') == true){
			$today = date("Y-m-d H:i:s");
			$bdd->exec('Insert into Log(membre_id, element_modif, date_modif, projet_id) Value(' . $_SESSION['user_session'] . ', " a modifié l\'état du projet", "'. $today . '", ' . $_SESSION['projet_id'] . ')');
			echo "<script>top.location.href='../Dashboard.php';</script>";
			exit;
		}else{
			echo 'Erreur d\'insertion';
		}
	}
?>

