<?php
	ini_set('display_errors','on');
	error_reporting(E_ALL);
	class backlog{
		public $num = 0;
		
		//Récupère les infos d'une US
		public function getInfos($id){
			try{
				$bdd = new PDO('mysql:host=localhost;dbname=MYP;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			}catch (Exception $e)
			{
				die('Erreur : ' . $e->getMessage());
			}
			
			$reponse = $bdd->query('Select * from UserStory where id = ' . $id );
			$donnees = $reponse->fetch();
			echo $donnees['description'] . '|' . $donnees['priorite'] . '|' . $donnees['effort'];
			$bdd=null;
		}
		
		//Affiche le backlog
		public function printBacklog($projetId){
			$userStories = array();
			try{
				$bdd = new PDO('mysql:host=localhost;dbname=MYP;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			}catch (Exception $e)
			{
				die('Erreur : ' . $e->getMessage());
			}
			$reponse = $bdd->query('Select id, numero, description, effort, priorite from UserStory where projet_id = ' .$projetId .  ' and sprint_id is null;');
			
			echo '<div class = "content">';
			echo '<div class = "back">';
			echo '<table id = "b">';
			echo '<tr id = "first"><td>US#</td><td>Description</td><td>Effort</td><td>Priorité</td><td>Modifications</td></tr>';
			while ($donnees = $reponse->fetch())
			{
				$us = array();
				array_push($us, $donnees['id'], $donnees['numero'], $donnees['description'], $donnees['effort'], $donnees['priorite']);
				$this->num++;
				echo '<tr>';
				echo '<td id = "numero">' . $donnees['numero'] . '</td>';
				echo '<td id = "description">' . $donnees['description'] . '</td>';
				echo '<td id = "effort">' . $donnees['effort'] . '</td>';
				echo '<td id = "priorite">' . $donnees['priorite'] . '</td>';
				echo '<td class = "modif" id = "' . $donnees['id'] . '"><a href="#" onClick = "charger('. $donnees['id'] .');"><img src="Icons/pencil.png" width = "30px"></img></a></td>';
				echo '</tr>';
			}
			echo '</table></div></div>';
			//$reponse2->closeCursor();
			//$reponse->closeCursor();
			$bdd = null;
		}

		//Ajouter une us à la fin
		public function addUs($desc, $prio, $eff, $proj){
			try{
				$bdd = new PDO('mysql:host=localhost;dbname=MYP;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			}catch (Exception $e)
			{
				die('Erreur : ' . $e->getMessage());
			}
			$numero = $this->num;
			$numero++;
			$bdd->exec('Insert into UserStory(numero, description, effort, priorite, projet_id) values ('.$numero.', "'.$desc.'", '.$eff.', '.$prio.', ' . $proj . ')');
			
		}
		
		//Modifier une us
		public function modifierUs($id, $desc, $prio, $eff){
			try{
				$bdd = new PDO('mysql:host=localhost;dbname=MYP;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			}catch (Exception $e)
			{
				die('Erreur : ' . $e->getMessage());
			}
			$bdd->exec('Update UserStory set description = "' . $desc . '", priorite = ' . $prio . ', effort = ' . $eff . ' where id = ' . $id);
			$bdd=null;
		}
	}
?>
