<?php

	if(!isset($_SESSION)) 
        { 
            session_start(); 
        } 
	
	require_once 'User.php';
	$session = new USER();
	
	
	if(!$session->is_loggedin())
	{		
		$session->redirect('login.php');
	}   