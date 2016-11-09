<?php
	session_start();
	include("Handlers/projects/get_projects.php");
	$projects = get_projects(10,$_SESSION['login']);
	
	include("Handlers/projects/get_logs.php");
	$logs = get_logs();
?>


<!DOCTYPE html>
<html lang="fr">
<head>	
	<meta charset="UTF-8">
	<link href="Css/workspace.css" rel="stylesheet" media="screen">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<script src = "http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="js/workspace.js"></script>
	
	<title> Mes projets </title>
</head>

<body>
<div class = "projet">
	<div class = "logo">
		<a href="#"><img src="icons/Logo2.png" title="Manage Your Project" alt="Manage Your Project" height = "50px" width = "100px"/></a>
	</div>
	<div class = "pseudo">
		<p><?php print($_SESSION['login']); ?></p>
		<a href="logout.php?logout=true"><img src="icons/quitter.png" title="Quitter" alt="Quitter" height = "25px" width = "25px"/></a>
	</div>
</div>

<div class = "container">
	<section id="projects_aside" class="responsive-2">
		<div class = "titre">
			<h2>Mes projets</h2><a href="add_project.php" id = "aj_project"> Nouveau projet</a>
		</div>
		<div id = "projects">
			<div id="projects_header">				
				<div class="projects_select" id="visibility_select">
					<div id="visibility_display">
						Visibilité
						<div id="visibility_selected">Tous</div>
					</div>
					<ul class="visibility_options">
						<li class="visibility_option" data-visibility="*">Tous</li>
						<li class="visibility_option" data-visibility="0">Public</li>
						<li class="visibility_option" data-visibility="1">Privé</li>
					</ul>
				</div>
				
				<div class="projects_select" id="state_select">
					<div id="state_display">
						Etat
						<div id="state_selected">Tous</div>
					</div>
					<ul class="state_options">
						<li class="state_option" data-state="*" >Tous</li>
						<li class="state_option" data-state="0">En cours</li>
						<li class="state_option" data-state="1">Finis</li>
					</ul>
				</div>
				
			</div>
			
			<div id="projects_display">
				<ul id="projects_display_list">
				<?php		
					$count = 0;
					$len = count($projects);
					foreach($projects as $p){
						$name = $p['nom'];
						$visibility = $p['flag_Prive'];
						$state = $p['flag_Etat'];
						
						$display =  '<li class="project_element" data-visibility="'.$visibility.'" data-state="'.$state.'">
										<a href="Handlers/projects/open_project.php?title='.$name.'">'.$name.'</a>
									</li>';								
						
						echo $display;
					}	
				?>
				</ul>
			</div>
		</div>
	</section>
	
	<section id="timeline" class="responsive-2">
		<h2>Timeline</h2>

		<div id="timeline_table">

		<?php
			foreach($logs as $log){
				$content = $log['element_modif'];
				$member= $log['member_name'];
				$project = $log['project_name'];
				$date = $log['date_modif'];
		
				$display =
				'<div class = "log"><div class = "message">' . $member . ' ' . $content .'</div><div class ="footer">' . $date . ' '. $project . '</div></div>';
				echo $display;		
			}
			?>
		</div>
	</section>

</div>

</body>
