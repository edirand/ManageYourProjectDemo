<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">

<title> Dashboard </title>
<script src = "http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src = "js/Projet-js.js"></script>
<link href="css/Projet.css" rel="stylesheet" media="screen">
</head>
<body>

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
