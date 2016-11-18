<?php
	session_start();	
	include("Handlers/projects/manage_doc.php");
	$doc = get_doc($_SESSION['projet_id']);	

	//$_SESSION['projet_id'];
?>


<!DOCTYPE html>
<html lang="fr">
<head>	
	<meta charset="UTF-8">
	<script src = "js/jquery-3.1.1.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<script src = "http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

	<script src="js/documentation.js"></script>
	<link href="CSS/documentation.css" rel="stylesheet" media="screen">
	<title> Documentation </title>
</head>

<body>	
	<section id="doc_section">
		<h1>Documentation</h1>
		<div class="doc_div">	
			
			<h2 class="toggle" data-toggle="true">Adresse du dépôt dev</h2>
			
			<div class="to_toggle">
				 <div id="adresse_dev_content" class="doc_content">
				<?php							
					echo nl2br($doc['adresse_dev']);
				?>
				</div>
				<div>
					<button type="button" class="doc_edit_button">Modifier</button> 
					<button type="button" class="doc_submit_button">Valider</button> 
				</div>
			</div>
		</div>
		
		<div class="doc_div">
			<h2  class="toggle" data-toggle="true">Adresse du dépôt démo</h2>
			<div  class="to_toggle">
				<div id="adresse_demo_content" class="doc_content">
				<?php				
					
					echo  nl2br($doc['adresse_demo']);
				?>
				</div>
				<div>
					<button type="button" class="doc_edit_button">Modifier</button> 
					<button type="button" class="doc_submit_button">Valider</button> 
				</div>
			</div>
		</div>
		
		<div class="doc_div">
			<h2  class="toggle" data-toggle="true">Politique des tests</h2>
			<div  class="to_toggle">
				 <div id="politique_tests_content" class="doc_content">
				<?php				
					
					echo nl2br($doc['politique_tests']);
				?>
				</div>
				<div>
					<button type="button" class="doc_edit_button">Modifier</button> 
					<button type="button" class="doc_submit_button">Valider</button> 
				</div>
			</div>
		</div>
		
		<div class="doc_div">
			<h2  class="toggle" data-toggle="true">Langages et outils utilisés</h2>
			<div  class="to_toggle">
				<div id="langages_outils_content" class="doc_content">				
				<?php				
					
					echo nl2br($doc['langages_outils']);
				?>
				</div>
				<div>
					<button type="button" class="doc_edit_button">Modifier</button> 
					<button type="button" class="doc_submit_button">Valider</button> 
				</div>
			</div>
		</div>
		
		<div class="doc_div">
			<h2  class="toggle" data-toggle="true">Règles des dépôts</h2>
			<div  class="to_toggle">
				<div id="regles_depot_content" class="doc_content">
				<?php				
					
					echo nl2br($doc['regles_depot']);
				?>
				</div>
				<div>
					<button type="button" class="doc_edit_button">Modifier</button> 
					<button type="button" class="doc_submit_button">Valider</button> 
				</div>
			</div>
		</div>
		
		<div class="doc_div">
			<h2  class="toggle" data-toggle="true">Qualité exigée</h2>
			<div class="to_toggle" >
				 <div id="regles_qualite_content" class="doc_content">
				<?php				
					
					echo nl2br($doc['regles_qualite']);
				?>
				</div>
				<div>
					<button type="button" class="doc_edit_button">Modifier</button> 
					<button type="button" class="doc_submit_button">Valider</button> 
				</div>
			</div>
		</div>
		
		
		
	</section>
</body>
