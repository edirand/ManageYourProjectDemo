<?php
	ini_set('display_errors','on');
	error_reporting(E_ALL);
	require_once 'backlog.php';

	session_start();

	$back = unserialize($_SESSION['backlog']);
	$back->addUs($_POST['desc'], $_POST['prio'], $_POST['eff'], $_SESSION['projet_id']);
	try{
		$bdd = new PDO('mysql:host=localhost;dbname=MYP;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}
	$today = date("Y-m-d H:i:s");
	$bdd->exec('Insert into Log(membre_id, element_modif, date_modif, projet_id) Value(' . $_SESSION['user_session'] . ', " a ajouté une US au backlog.", "'. $today . '", ' . $_SESSION['projet_id'] . ')');
	$bdd = null;
	
	echo '<?php include "Handlers/backlog/getBack.php" ?>';
?>
