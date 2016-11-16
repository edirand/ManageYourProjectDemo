<?php
	session_start();
	require_once('Handlers/Sprints/tasks.php');
	$listes = unserialize($_SESSION['taches']);
	?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">

<title> Dashboard </title>
<script src = "http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="CSS/Sprint.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>
<body>
<div class="hiddenRequetes"></div>
<div class="pop_background" id="pop_background">
</div>
<div class="popup" id = "popup">
<div class = "corps">
Tache n°1
<div class = "p_partie">
<div class = "p_titre">
Description
</div>
<div class = "p_content">
<p>Ajoutez une description de la tâche.</p>
<textarea name="desc" rows="10" cols="120" id = "description"></textarea>
</div>
</div>
<div class = "p_partie">
<div class = "p_titre">
Planning
</div>
<div class = "p_content" id="dates">
<div class = "date">
<label for="debut">Date de début prévue</label>
<input type="date" name="debut" id = "debutT">
</div>
<div class = "date">
<label for="fin"> Date de fin prévue</label>
<input type="date" name="fin" id = "finT">
</div>
</div>
</div>

<div class = "p_partie">
<div class = "p_titre">
Développement
</div>
<div class = "p_content">
<p>Choisissez un développeur et indiquez le coût en j/h de la tâche.</p>
<SELECT name="TacheDev" size="1" id="developpeur">
		<?php $listes->printEquipe();?>
					</SELECT>
					<input type="number" name="TacheCout" min="0.5" step="0.5" value="0.5" id = "cout"/>
				</div>
			</div>
			<div class = "p_partie">
				<div class = "p_titre">
					User Stories
				</div>
				<div class = "p_content">
					<p>Sélectionnez les US traitées par cette tâche.</p>
					<div class = "listes">
						<div class = "usListe">
							<?php $listes->printUS();?>
						</div>
					</div>
				</div>
			</div>
			<div class = "p_partie">
				<div class = "p_titre">
					User Stories
				</div>
				<div class = "p_content">
					<p>Sélectionnez les dépendances avec les tâches déjà créées.</p>
					<div class = "listes">
						<div class = "tachesListe" id="lt">
							<?php $listes->printAllTachesListe();?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<a href="#" id="popAnnul">Annuler</a>

		<a href="#" id="popValid">Valider</a>

	</div>

	<div class = "contenu">
<div class = "numSprint"><h1>Sprint #<?php echo $_SESSION['sprint_id'];?></h1></div>
			<div class = "partie">
				<div class = "title"><img src = "Icons/calendar.png" width = "30px"/>Délais</div>
				<div class = "content" id="dates">
					<div class = "date">
							<label for="debut"> Indiquez une date de début du sprint</label>
							<input type="date" name="debut" id = "debut">
					</div>
					<div class = "date">
						<label for="fin"> Indiquez une date de fin du sprint</label>
						<input type="date" name="fin" id = "fin">
					</div>
				</div>
				</div>



				<div class = "partie">
					<div class = "title"><img src = "Icons/list.png" width = "30px"/>Tâches<a href="#" id ="add"><img src="Icons/add-sprint.png" width = "30px"/></a></div>
					<div class = "content" id="tasks">
						<?php $listes->printAllTachesPostIt();?>
					</div>
				</div>
<div class="boutons">
				<a href="#" onclick="valider();"/>Valider</a>
				<a href="#" id="Retour" onclick = "retour();">Annuler</a>
</div>
			</form>
		</div>
	</body>
</html>

<script>
var modif = false;
var idModif = 0;

$(document).ready(function() {

				  $('#add').click(function(){
								  $('#popup').fadeIn();
								  $('#pop_background').fadeIn();
								  $.get("Handlers/Sprints/list_tache_handler.php", function(data){
										$("#lt").replaceWith(data);
										});
								  return false;
								  });
				  $('#pop_background').click(function(){
											 $('#popup').fadeOut();
											 $('#pop_background').fadeOut();
											 return false;
											 });
				  $('#popAnnul').click(function(){
									   $('#popup').fadeOut();
									   $('#pop_background').fadeOut();
									   return false;
									   });
				  $('#popValid').click(function(){
									   var description;
									   var cout;
									   var usL;
									   var developpeur;
									   var dependance;
									   var date1 = $("#debutT").val();
									   var date2 = $("#finT").val();
									   if(date1==""||date2==""){
									   alert('Veuillez entrer les dates de début et de fin du sprint');
									   return;
									   }
									   
									   //On rajoute les guillemets sur les chaines
									   description = $("#description").val();
									   $("#description").val("");
									   
									   developpeur = $("#developpeur").val();
									   $("#developpeur").val("");
									   
									   //Transforme la chaine en float
									   cout = $("#cout").val();
									   $("#cout").val(0.5);
									   cout = parseFloat(cout);
									   
									   //Récupère les us cochées
									   var premier = true;
									   usL='"';
									   $(".checkboxUs:checked").each(function(){
																	 if(premier){
																	 usL += (parseInt($(this).val())+1);
																	 premier = false;
																	 }
																	 else{
																	 usL += ','+(parseInt($(this).val())+1);}
																	 $(this).attr("checked",false);
																	 });
									   usL +='"';
									   if(premier){
										alert('Vous devez cocher au moins une US');
									   return false;
									   }
									   
									   premier = true;
									   dependance = '"';
									   $(".checkboxTache:checked").each(function(){
																		if(premier){
																		dependance += (parseInt($(this).val())+1);
																		premier=false;
																		}else
																		dependance += ','+ (parseInt($(this).val())+1);
																		$(this).attr("checked",false);
																		});
									   dependance +='"';
									   if(premier){
										dependance = "null";
									   }
									   
									   if(modif){
									   $.post("Handlers/Sprints/modif_tache_handler.php", {id : idModif, desc : description, cost : cout, us : usL, dev : developpeur, dep : dependance, deb : date1, fin : date2}, function(data){
												 $("#tasks").replaceWith(data);

											  });
									   
									   }else{
									   $.post("Handlers/Sprints/creer_tache_handler.php", {desc : description, cost : cout, us : usL, dev : developpeur, dep : dependance, deb : date1, fin : date2}, function(data){
												 $("#tasks").replaceWith(data);
											  });
									   
									   }
									   
									   $('#popup').fadeOut();
									   $('#pop_background').fadeOut();
									   return false;
									   });
				  $('#debut').datepicker({ dateFormat: "yy-mm-dd"});
				  $('#fin').datepicker({ dateFormat: "yy-mm-dd"});
				  $('#debutT').datepicker({ dateFormat: "yy-mm-dd"});
				  $('#finT').datepicker({ dateFormat: "yy-mm-dd"});
				  });

function charger(i){
	
	$.get("Handlers/Sprints/getInfos_tache_handler.php", {id : i}, function(data){
		  var tokens = data.split("|");
		  $("#description").val(tokens[0]);
		  $("#developpeur").val(tokens[1]);
		  $("#cout").val(tokens[2]);
		  var US = tokens[3].split(",");
		  var dep = tokens[4].split(",");
		  $("#debutT").val(tokens[5]);
		  $("finT").val(tokens[6]);
		  
		  var id
		  for(var i=0; i<$(US).length; i++){
			id = US[i];
			$(".checkboxUs[value=" + (parseInt(id) -1) +"]").prop("checked",true);
		  };
		  
		  for(var i=0; i<$(dep).length ; i++){
		  id = dep[i];
		  $(".checkboxTache[value=" + (parseInt(id) -1) + "]").prop("checked",true);
		  };
		  });
	
	$('#popup').fadeIn();
	$('#pop_background').fadeIn();
	modif = true;
	idModif = i;
}

function supprimer(i){
	$.post("Handlers/Sprints/suppr_tache_handler.php", {id : i}, function(data){
		   $("#tasks").replaceWith(data);
		   $.get("list_tache_handler.php", function(data){
				 $(".tachesListes").replaceWith(data);
				 });});
}

function retour(){
	$.post("Handlers/Sprints/reinitialize_session.php", function(){
		   top.location.href='Dashboard.php';
		   });
}

function valider(){
	var date1 = $("#debut").val();
	var date2 = $("#fin").val();
	if(date1==""||date2==""){
		alert('Veuillez entrer les dates de début et de fin du sprint');
		return;
	}
	$.post("Handlers/Sprints/enregistrer_sprint_handler.php", {debut : date1, fin : date2}, function(){
		   retour();
		   });
}

</script>
