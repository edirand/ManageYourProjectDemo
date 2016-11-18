<?php
session_start();
include("manage_commit.php");
update_commit($_SESSION['projet_id'],
    $_POST['valeur'],
    $_POST['id_num']);

?>
