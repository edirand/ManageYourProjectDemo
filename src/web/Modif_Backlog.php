<?php
	session_start();
	?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">

<title> Dashboard </title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<link href="css/Modif.css" rel="stylesheet" media="screen">
</head>
<body>

<div class="pop_background" id="pop_background"></div>
<div class="popup" id = "popup">
	<div class = "corps">
		<div class = "p_partie">
			<div class = "p_titre">
				Description
			</div>
			<div class = "p_content">
			<p>Ajoutez une description de l'US.</p>
			<textarea name="desc" rows="10" cols="115" id = "description"></textarea>
			</div>
			<div class = "p_titre">
				Effort et priorité
			</div>
			<div class = "p_content">
				<p>Indiquez l'effort et la priorité de la tâche</p>
				<input type="number" name="eff" min="1" step="1" value="1" id = "eff"/>
				<input type="number" name="prio" min="1" step="1" value="1" id = "prio"/>
			</div>
		</div>
		<a href="#" id="popAnnul">Annuler</a>
		<a href="#" id="popValid">Valider</a>
	</div>
</div>

	<div class = "contenu">
		<div class = "title"><p>Modifier le backlog</p></div>
		<div class = "corps">
<div class = "desc">Ajoutez de nouvelles US ou modifier les US existantes. Attention : vous ne pouvez modifier que les US qui n'ont pas encore été traitées ou qui n'ont pas été sélectionnées dans un sprint.</div>
			<a href="#" id ="add"><img class = "ImgAjout" src ="icons/plus.png" width = "30px"></img></a>
			<div id = "content"></div>
		</div>
	</div>
</body>
</html>

<script>
var modif = false;
var idModif = 0;

$(document).ready(function() {
				  getBack();

				  $('#add').click(function(){
								  $("#description").val("");
								  $("#prio").val(1);
								  $("#eff").val(1);

								  $('#popup').fadeIn();
								  $('#pop_background').fadeIn();
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
									   var prio;
									   var effort;
									   
									   description = $("#description").val();
									   $("#description").val("");
									   
									   //Transforme la chaine en int
									   prio = $("#prio").val();
									   $("#prio").val(1);
									   prio = parseInt(prio);
									   
									   //Transforme la chaine en int
									   eff = $("#eff").val();
									   $("#eff").val(1);
									   eff = parseInt(eff);
									   
									   if(modif){
									   $.post("Handlers/backlog/modif_us_handler.php", {id : idModif, desc : description, prio : prio, eff : eff}).done(function(){
													modif=false;
													location.reload();

													  });
									   
									   }else{
									   $.post("Handlers/backlog/add_us_handler.php", {desc : description, prio : prio, eff : eff}, function(){
											  location.reload();
											  });
									   }
									   $('#popup').fadeOut();
									   $('#pop_background').fadeOut();
									   return false;
									   });});

function charger(i){
	$.get("Handlers/backlog/getList.php", {id : i}, function(data){
		  var tokens = data.split("|");
		  $("#description").val(tokens[0]);
		  $("#prio").val(tokens[1]);
		  $("#eff").val(tokens[2]);
		});
	
	$('#popup').fadeIn();
	$('#pop_background').fadeIn();
	modif = true;
	idModif = i;
}

function getBack(){
	$.post("Handlers/backlog/getBack.php").done(function(data){
		   $("#content").replaceWith(data);
		   });
}
</script>
