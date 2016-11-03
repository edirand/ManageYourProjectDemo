<?php
	session_start();

?>


<!DOCTYPE html>
<html lang="fr">
<head>	
	<meta charset="UTF-8">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<script src = "http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="js/add_project.js"></script>
	<link href="Css/add_project.css" rel="stylesheet" media="screen">	
	<title> Ajouter un projet </title>
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

	<section>
		<form method="post" id="add_project_form" action="Handlers/projects/add_project_handler.php">
		<div>
			<input type="submit" value="Valider ce projet" id="add_project_submit" class="clickable">			
			<span id="cancel"><a href="workspace.php">Annuler</a></span>
		</div>
			<div id="project_fields">
				<div class="project_field">
					<label for="project_name">Nom du projet</label>
					<input type="text" name="project_name" id="project_name"/>
				</div>
				
				<select name="project_visibility" form="add_project_form" id="project_visibility">
					<option value="0">Public</option>
					<option value="1">Privé</option>
				</select>
				
				<div class="project_field">
					<label for="project_description">Description du projet</label>
					<textarea form="add_project_form" 
					name="project_description" id="project_description"
					maxlength="1024"></textarea>
				</div>
			</div>

			<div class = "right">
			<div class = "adresses">
<div class="project_field">
<label for="project_repdev">Adresse du dépôt dev</label>
<input type="text" name="project_repdev" id="project_repdev"/>
</div>

<div class="project_field">
<label for="project_repdemo">Adresse du dépôt démo</label>
<input type="text" name="project_repdemo" id="project_repdemo"/>
</div>
</div
			<div id="US_fields">
				<table id="US_table">
					<tr class="US_tr">
						<th></th>
						<th>Description</th>
						<th>Effort</th>
						<th>Priorité</th>
					</tr>
					<tr class="US_tr">
						<td  class="US_td">US#1</td>
						<td>
							<textarea form="add_project_form" name="US[1][description]"
							maxlength="1024" class="US_description"></textarea>
						</td>
						<!--<td><input type="text" name="US[1][description]" class="US_description"/></td>-->
						<td class="US_td"><input type="number" min="1" name="US[1][cost]" value="1"/></td>
						<td class="US_td"><input type="number" min="1" name="US[1][priority]" value="1"/></td>
					</tr>
				</table>				
				
				<button type="button" class="clickable" id="add_US_button" >Ajouter une User Story</button> 
			</div>
		</div>
		</form>
	</section>
</body>
