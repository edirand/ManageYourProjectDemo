<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">

<title> Dashboard </title>
<script src = "http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src = "js/Equipe-js.js"></script>
<link href="css/Equipe.css" rel="stylesheet" media="screen">
</head>

<body>

<div id="pop_background"></div>
<div id="pop_box">
<form>
<input id = "recherche" type="text" name="firstname">
</form>
<div id="Resultat"></div>
</div>
<div class = "contenu">
<h1> Équipe du projet </h1>
<div class = "boutons">
<a href = "#" id ="add"><img src = "icons/add-user.png" width = "32px"/></a>
</div>
<div id="membres">
</div>
</div>
</body>
</html>

<script>
$(document).ready(function(){
				  $('#add').click(function(){
								  $('#pop_background').fadeIn();
								  $('#pop_box').fadeIn();
								  return false;
								  });
				  $('#pop_background').click(function(){
											 $('#pop_background').fadeOut();
											 $('#pop_box').fadeOut();
											 location.reload(true);
											 return false;
											 });
				  });

$('#recherche').keyup(function() {
					  var name = $('#recherche').val();
					  var idProjet = 1;
					  search(name, idProjet);
					  });

$(function chargerEquipe(){
  $.get('Handlers/Equipe_handler.php', function(tableau){
		$('div#membres').html((tableau));
		});});


</script>
