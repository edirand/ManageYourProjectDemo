<?php
	ini_set('display_errors','on');
	error_reporting(E_ALL);
	class listeTasks{
		public $_taches = array();
		public $_usRestantes = array();
		public $_equipe = array();
		
		
		
		//Permet de créer une nouvelle tâche et de l'ajouter dans le tableau
		public function creerTache($description, $cout, $etat, $us, $dependances, $developpeur, $debut, $fin){
			$tache = array();
			array_push($tache, $description, $cout, $etat, $us, $dependances, $developpeur, $debut, $fin);
			array_push($this->_taches, $tache);
			
		}
		
		public function printTest(){
			return $this->_taches[0][3];
		}
		
		//Permet de récupérer l'équipe du projet.
		public function chargerEquipe($idProjet){
			try{
				$bdd = new PDO('mysql:host=localhost;dbname=MYP;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			}catch (Exception $e)
			{
				die('Erreur : ' . $e->getMessage());
			}
			$reponse = $bdd->query('Select id, login from Membres where id in (Select membre_id from Developpeurs where projet_id =' . $idProjet . ')');
			
			//ajoute les devs du projet.
			while($donnees = $reponse->fetch()){
				array_push($this->_equipe, $donnees['id'].','.$donnees['login']);
			}
			$reponse->closeCursor();
			$bdd = null;
		}
		
		//Affiche les membres de l'équipe
		public function printEquipe(){
			for($i = 0; $i < sizeof($this->_equipe); $i++){
				$ligne = $this->_equipe[$i];
				$ligne = explode(",", $ligne);
				echo '<OPTION>' . $ligne[1];
			}
		}
		
		//Récupère la liste des US non traitées
		public function chargerUsRestantes($idProjet){
			try{
				$bdd = new PDO('mysql:host=localhost;dbname=MYP;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			}catch (Exception $e)
			{
				die('Erreur : ' . $e->getMessage());
			}
			$reponse = $bdd->query('Select * from UserStory where projet_id =' . $idProjet . ' and sprint_id is null');
			
			while($donnees = $reponse->fetch()){
				$us = array();
				array_push($us, $donnees['numero'],$donnees['description'],$donnees['effort'],$donnees['priorite']);
				array_push($this->_usRestantes, $us);
			}
			$reponse->closeCursor();
			$bdd = null;
		}
		
		
		//Affiche les US restantes (non terminées)
		public function printUS(){
			for($i = 0; $i < sizeof($this->_usRestantes); $i++){
				echo '<div class="Us">';
				echo '<table>';
				echo '<tr><td><input type="checkbox" class="checkboxUs" value ="' . $this->_usRestantes[$i][0] . '"></td>';
				echo '<td>';
				echo '<div class= "UsDesc">US#'.$this->_usRestantes[$i][0].' : '.$this->_usRestantes[$i][1].'</div>';
				echo '<div class="nb">Effort : '.$this->_usRestantes[$i][2].'<br/>Priorité : '.$this->_usRestantes[$i][3].'</div>';
				echo '</td></tr></table>';
				echo '</div>';
			}
			
		}
		
		
		//Affiche la liste des taches sous forme de post-it
		public function printAllTachesPostIt(){
			echo '<div class = "content" id="tasks">';
			for($i = 0; $i < sizeof($this->_taches); $i++){
				echo '<div class="post-it-container">';
				echo '<div class="note yellow">';
				echo '<div class= "noteCorps">';
				echo '<div class="noteTitre"> Tâche ' . strval($i+1) . '</div>';
				echo '<div class="champ">Description : ' . $this->_taches[$i][0] . '</div>';
				echo '<div class="champ">Coût : ' . $this->_taches[$i][1] . '</div>';
				echo '<div class="champ">Développeur : ' . $this->_taches[$i][5] . '</div>';
				echo '<div class="champ">Dépendances : ' . $this->_taches[$i][4] . '</div>';
				$us = explode(",",implode(explode('"', $this->_taches[$i][3])));
				$res = "";
				for($j = 0; $j < sizeof($us); $j++){
					$us[$j] = intval($us[$j]);
					$res = $res . strval($us[$j]);
					if( ($j+1) < (sizeof($us))){
						$res = $res .  ",";
					}
				}
				echo '<div class="champ">US : ' . $res . '</div>';
				echo '</div><div class="noteFooter"><a href = "#" onclick ="charger(' . $i . ');"><img src="Icons/pencil.png" width="20px"/></a><a href = "#" onclick ="supprimer(' . $i . ');"><img src="Icons/trash.png" width="20px"/></a></div>';

				echo '</div>';
				echo '</div>';
			}
			echo'</div>';
		}
		
		//Affiche la tache i
		public function printTache($i){
			echo '<p>';
			echo $i. ': <br/>';
			for($j = 0; $j<6; $j++){
				echo $this->_taches[$i][$j] . ' ';
			}
			echo '</p>';
		}
		
		
		public function printAllTachesListe(){
			echo '<div class = "tachesListe" id = "lt">';
			for($i = 0; $i < sizeof($this->_taches); $i++){
				echo '<div class="task">';
				echo '<table><tr><td>';
				echo '<input type="checkbox" class="checkboxTache" value = "' . strval($i) . '"></td><td>';
				echo 'T' . strval($i+1) . ' : ' . $this->_taches[$i][0];
				echo '</td></tr></table>';
				echo '</div>';
			}
			echo '</div>';
		}
		
		//Supprime l'élément à la position i et réindexe le tableau
		public function supprimerTache($i){
			array_splice($this->_taches, $i, 1);
		}
		
		//Modifie l'élément à la position i
		public function modifierTache($i, $description, $cout, $etat, $us, $dependances, $developpeur, $debut, $fin){
			$tache = array();
			array_push($tache, $description, $cout, $etat, $us, $dependances, $developpeur, $debut, $fin);
			$this->_taches[$i] = $tache;
		}
		
		public function supprimerAll(){
			$this->_taches = array();
			$this->_equipe = array();
			$this->__usRestantes = array();
		}
		
		public function getInfos($i){
			$res = $this->_taches[$i][0] . '|' . $this->_taches[$i][5] . '|' . $this->_taches[$i][1]. '|' . str_replace('"', "", $this->_taches[$i][3]). '|' . str_replace('"', "",$this->_taches[$i][4]) . '|' . $this->_taches[$i][6] . '|' . $this->_taches[$i][7];
			return $res;
		}
		
		//Récupère id Dev 
		public function getDevId($login, $projetId){
			try{
				$bdd = new PDO('mysql:host=localhost;dbname=MYP;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			}catch (Exception $e)
			{
				die('Erreur : ' . $e->getMessage());
			}
			$reponse = $bdd->query('Select id from Developpeurs where membre_id = (select id from Membres where login = "' . $login . '") and projet_id = ' . $projetId);
			$donnees = $reponse->fetch();
			$reponse->closeCursor();
			$bdd = null;
			return $donnees['id'];
		}
		
		public function enregistrerAllTaches($idSprint, $projetId){
			try{
				$bdd = new PDO('mysql:host=localhost;dbname=MYP;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			}catch (Exception $e)
			{
				die('Erreur : ' . $e->getMessage());
			}
			for($i = 0; $i < sizeof($this->_taches); $i++){
				$desc = $this->_taches[$i][0];
				$cout = $this->_taches[$i][1];
				$etat = $this->_taches[$i][2];
				$us = $this->_taches[$i][3];
				$dep = $this->_taches[$i][4];
				$dev = $this->_taches[$i][5];
				$deb = $this->_taches[$i][6];
				$fin = $this->_taches[$i][7];

				//On récupère l'id du développeur
				$idDev = $this->getDevId($dev, $projetId);
				$num = strval(intval($i)+1);
				$reponse = $bdd->exec ('Insert into Taches(numero, description, cout, etat, sprint_id, us, developpeur_id, dependances, date_debut, date_fin) value (' . $num . ',"' .$desc . '", ' . $cout . ',' . $etat . ',' . $idSprint . ',' . $us . ',' . $idDev . ',' . $dep . ',"' . $deb . '", "' . $fin . '");');
			}
			$bdd = null;
		}
		
		public function enregistrerUsChoisies($idSprint, $projetId){
			try{
				$bdd = new PDO('mysql:host=localhost;dbname=MYP;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			}catch (Exception $e)
			{
				die('Erreur : ' . $e->getMessage());
			}
			for($i = 0; $i<sizeof($this->_taches); $i++){
				//On récupère la liste des US
				$tokens = explode(",",(implode(explode('"', $this->_taches[$i][3]))));
				for($j = 0; $j<sizeof($tokens); $j++){
					//Si l'US n'est pas encore dans le tableau, on l'ajoute
					if(!(in_array($tokens[$j], $UsChoisies))){
						array_push($UsChoisies, $tokens[$j]);
						$bdd->exec('Update UserStory set sprint_id = ' . $idSprint . ' where numero = ' . $tokens[$j] . ' and projet_id = ' . $projetId . ';');
					}
				}
			}
			
			$bdd = null;
		}
		
		//Affiche la liste des taches de la bdd sous forme de post-it en fonction de l'état
		public function printTachesPostIt($etat, $sprintId){
			try{
				$bdd = new PDO('mysql:host=localhost;dbname=MYP;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			}catch (Exception $e)
			{
				die('Erreur : ' . $e->getMessage());
			}
			
			$reponse = $bdd->query('Select * from Taches where sprint_id = ' . $sprintId . ' and etat = ' . $etat . ';');
			
			while($donnees = $reponse->fetch()){
				//Récupère le login du dev de la tâche
				$reponse2 = $bdd->query('Select login from Membres where id = (select membre_id from Developpeurs where id = ' . $donnees['developpeur_id'] . ');');
				$res = $reponse2->fetch();
				$login =  $res['login'];
				echo '<div class="post-it-container">';
				echo '<div class="note yellow">';
				echo '<div class= "noteCorps">';
				echo '<div class="noteTitre"> Tâche ' . $donnees['numero'] . '</div>';
				echo '<div class="champ">Description : ' . $donnees['description'] . '</div>';
				echo '<div class="champ">Coût : ' . $donnees['cout'] . '</div>';
				echo '<div class="champ">Développeur : ' . $login . '</div>';
				echo '<div class="champ">Dépendances : ' . $donnees['dependances'] . '</div>';
				echo '<div class="champ">US : ' . $donnees['us'] . '</div>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
			}
		}
	}
?>
