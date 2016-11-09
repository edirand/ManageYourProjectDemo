<?php
	session_start();
	require_once("User.php");
	$login = new USER();
	
	if($login->is_loggedin()!="")
	{
		$login->redirect('Dashboard.php');
	}
	
	if(isset($_POST['btn-login']))
	{
		$uname = strip_tags($_POST['txt_uname_email']);
		$umail = strip_tags($_POST['txt_uname_email']);
		$upass = strip_tags($_POST['txt_password']);
		
		if($login->doLogin($uname,$umail,$upass))
		{
			$login->redirect('workspace.php');
		}
		else
		{
			$error = "Les informations entrées n'ont pas permis de vous identifier... Avez vous vérifié l'adresse mail ou le mot de passe ?";
		}
	}
	
	if(isset($_POST['btn-visit']))
	{
		$_SESSION['user_session'] = 1;
		$_SESSION['login'] = 'Visiteur';
		$login->redirect('workspace.php');
		
	}
	
	?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ManageYourProject : Connexion</title>
<link rel="stylesheet" href="CSS/style.css" type="text/css"  />
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>
<body>

<div class="signin-form">

<div class="container">

<form class="form-signin" method="post" id="login-form">

<h2 class="form-signin-heading">Se connecter</h2>

<div id="error">
<?php
	if(isset($error))
	{
		?>
<div class="alert-danger">
<?php echo $error; ?>
</div>
<?php
	}
	?>
</div>

<div class="form-group">
<input type="text" class="form-control" name="txt_uname_email" placeholder="Login ou email" />
<span id="check-e"></span>
</div>

<div class="form-group">
<input type="password" class="form-control" name="txt_password" placeholder="Mot de passe" />
</div>

<div class="form-group">
<button type="submit" name="btn-login" class="btn-primary">
Connexion
</button>
<button type="submit" name="btn-visit" class="btn-sec">
Continuer en tant que visiteur
</button>

</div>
<br />
<label>Vous n'avez pas encore de compte sur ManageYourProject ?  <a href="sign-up.php">S'inscrire</a></label>
</form>

</div>

</div>

</body>
</html>
