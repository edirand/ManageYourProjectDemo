<?php
	session_start();
	require_once('User.php');
	$user = new USER();
	
	if($user->is_loggedin()!="")
	{
		$user->redirect('home.php');
	}
	
	if(isset($_POST['btn-signup']))
	{
		$uname = strip_tags($_POST['txt_uname']);
		$umail = strip_tags($_POST['txt_umail']);
		$upass = strip_tags($_POST['txt_upass']);
		
		if($uname=="")	{
			$error[] = "Veuillez entrer un login !";
		}
		else if($umail=="")	{
			$error[] = "Veuillez entrer une adresse email";
		}
		else if(!filter_var($umail, FILTER_VALIDATE_EMAIL))	{
			$error[] = 'Veuillez entrer une adresse email valide !';
		}
		else if($upass=="")	{
			$error[] = "Vous avez besoin d'un mot de passe pour vous inscrire";
		}
		else if(strlen($upass) < 6){
			$error[] = "Le mot de passe doit être composé d'au moins 6 caractères";
		}
		else
		{
			try
			{
				$stmt = $user->runQuery("SELECT login, mail FROM membres WHERE login=:uname OR mail=:umail");
				$stmt->execute(array(':uname'=>$uname, ':umail'=>$umail));
				$row=$stmt->fetch(PDO::FETCH_ASSOC);
				
				if($row['login']==$uname) {
					$error[] = "Ce login est déjà utilisé...";
				}
				else if($row['mail']==$umail) {
					$error[] = "Cette adresse email est déjà utilisée...";
				}
				else
				{
					if($user->register($uname,$umail,$upass)){
						$user->redirect('sign-up.php?joined');
					}
				}
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}
		}
	}
	
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ManageYourProject : Inscription</title>
<link rel="stylesheet" href="CSS/style.css" type="text/css"  />
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>
<body>

<div class="signin-form">

<div class="container">

<form method="post" class="form-signin">
<h2 class="form-signin-heading">S'inscrire</h2>
<?php
	if(isset($error))
	{
		foreach($error as $error)
		{
			?>
<div class="alert-danger">
<?php echo $error; ?>
</div>
<?php
	}
	}
	else if(isset($_GET['joined']))
	{
		?>
<div class="alert-info">
Vous êtes bien inscrit sur ManageYourProject !  <a href='login.php'>Connectez-vous ici !</a>
</div>
<?php
	}
	?>
<div class="form-group">
<input type="text" class="form-control" name="txt_uname" placeholder="Login" value="<?php if(isset($error)){echo $uname;}?>" />
</div>
<div class="form-group">
<input type="text" class="form-control" name="txt_umail" placeholder="email" value="<?php if(isset($error)){echo $umail;}?>" />
</div>
<div class="form-group">
<input type="password" class="form-control" name="txt_upass" placeholder="Mot de passe" />
</div>
<div class="clearfix"></div>
<div class="form-group">
<button type="submit" class="btn btn-primary" name="btn-signup">
S'inscrire
</button>
</div>
<br />
<label>Vous possédez déjà un compte ? <a href="login.php">Se connecter</a></label>
</form>
</div>
</div>

</div>

</body>
</html>
