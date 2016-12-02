<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">

<title> Dashboard </title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script src = "js/Projet-js.js"></script>
<script src = "js/Sprint.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js"></script>

<link href="css/Projet.css" rel="stylesheet" media="screen">
</head>
<body>

<div class= "pop-background">
</div>
<div class = "pop" title = "Cette tâche est terminée ?">
Une tâche validée ne peut plus être replacée en On Going. Cette tâche est-elle vraiment terminée ?
<div class = "boutons">
	<input type="button" value="Valider" id = "val">
	<input type="button" value="Annuler" id="annul">
</div>
</div>
<div class = "contenu">
	<div id = "onglets">
	</div><div id = "content">
	</div>
</div>
</body>
</html>

<script>
$(document).ready(function(){
				  descProjet();
				  getOnglets(1);
				  });


</script>
