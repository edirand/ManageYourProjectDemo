<?php
	
	include("insert_project.php");
	include("insert_US.php");
	include("insert_doc.php");

	if( isset($_POST['US'])&&
		isset($_POST['project_visibility'])&&
		isset($_POST['project_name'])&&
		isset($_POST['project_repdev'])&&
		isset($_POST['project_repdemo'])&&
		isset($_POST['project_description'])
		){
	
		 
		$project_id = insert_project(
						$_POST['project_name'],
						$_POST['project_description'],
						$_POST['project_visibility'],
						0);
	
		$US = $_POST['US'];
		$count = 0;
		foreach($US as $us){			
			insert_US(++$count, $us['description'], $us['cost'], $us['priority'],$project_id);
		}
		
		insert_repositories($project_id,$_POST['project_repdev'],$_POST['project_repdemo']);
		
		header('Location: ../../workspace.php');

			
	}
		
	
	

?>