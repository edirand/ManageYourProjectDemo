<?php
	require_once("session.php");
	
	require_once("User.php");
	$auth_user = new USER();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">

<title> Dashboard </title>
<script src = "http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="js/Dashboard-js.js"></script>
<link href="css/Dashboard.css" rel="stylesheet" media="screen">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>

<body>

<div class = "projet">
<div class = "logo">
<a href="workspace.php"><img src="icons/Logo2.png" title="Manage Your Project" alt="Manage Your Project" height = "50px" width = "100px"/></a></div>
<div class = "title">
<h1><?php echo $_SESSION['projet_nom']; ?></h1>
<a href="workspace.php"><img src="icons/quitter.png" title="Fermer le projet" alt="Quitter" height = "25px" width = "25px"/></a>
</div>
<div class = "pseudo">
<p><?php print($_SESSION['login']); ?></p>
<a href="logout.php?logout=true"><img src="icons/quitter.png" title="Quitter" alt="Quitter" height = "25px" width = "25px"/></a>
</div>
</div>

<nav class="menu">
<ul>
<li id="nav-equipe"><a href="Equipe.php" onclick="changeColor('nav-equipe', 'equipe')" target="corps"><img id="equipe" src="icons/equipe.png" title="Equipe" alt="Equipe" height = "32px" width = "32px"/></a></li>
<li id="nav-graphe" ><a href="graphe.php" onclick="changeColor('nav-graphe', 'graphe')" target="corps"><img id="graphe" src="icons/graphe.png" title="Statistiques" alt="Graphes" height = "32px" width = "32px"/></a></li>
<li id="nav-doc"><a href="doc.php" onclick="changeColor('nav-doc', 'docs')" target="corps"><img id="docs" src="icons/docs.png" title="Documentation" alt="Documentation" height = "32px" width = "32px"/></a></li>
<li id="nav-param"><a href="Parametres.php" onclick="changeColor('nav-param', 'param')" target="corps"><img id="param" src="icons/param.png" title="Paramètres" alt="Paramètres" height = "32px" width = "32px"/></a></li>
<li id="nav-home"><a href="Projet.php" target="corps" onclick="changeColor('nav-home', 'home')"><img id="home" src="icons/home.png" title="Accueil" alt="Home" height = "32px" width = "32px"/></a></li>
</ul>
</nav>

<div class="container">
<iframe id="content" src="Projet.php" name="corps"></iframe>
</div>

<script>
$(document).ready(function(){
				  $('#nav-home').click(changeColor('nav-home', 'home'));
				  });
</script>
</body>

</html>
