<?php
session_start();
include("manage_doc.php");
update_doc($_SESSION['projet_id'],
		$_POST['adresse_dev'],
		$_POST['adresse_demo'],
		$_POST['politique_tests'],
		$_POST['langages_outils'],
		$_POST['regles_depot'],
		$_POST['regles_qualite']);





?>