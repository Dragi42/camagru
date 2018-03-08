<html>
	<head>
		<meta charset='utf-8'>
		<meta name="viewport" content="width=device-width, initial-scale=0.7">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> 
		<link rel='stylesheet' type='text/css' href='../style/index.css'>
		<link rel="icon" type="image/x-icon" href="../favicon.ico"/>
	</head>
		<div id='header'>
			<div class='logo'>
				<a href='.'><img src='favicon.ico' alt='Camagru' /></a>
				<a href='.'><h2>Camagru</h2></a>
			</div>
			<div class='nav'>
				<ul class='list'>
				<?php if ($_SESSION['id']): ?>
					<li><a href='./?module=home&action=index' name='loginhead' title='Home'><?= $_SESSION['login']; ?></a></li>
					<li><a href='./' title='Accueil'>Accueil</a></li>
					<li><a href='./?module=settings&action=index' title='Settings'><i class='material-icons'>settings</i></a></li>
					<li><a href='./modules/account/logout.php' title='Log out'>Log out</a></li>
				<?php endif; ?>
				<?php if (!$_SESSION['id']): ?>
					<li><a href='./?module=account&action=index'>Sign in / Sign up</a></li>
				<?php endif; ?>
				</ul>
			</div>
		</div>
		<div class="container">
				<?php	if(array_key_exists('errors', $_SESSION)):	?>
					<div class="alert alert-danger">
						<?= implode('<br>', $_SESSION['errors']); ?>
					</div>
				<?php endif; ?>
				<?php	if(array_key_exists('success', $_SESSION)): ?>
					<div class="alert alert-success">
						<?= implode('<br>', $_SESSION['success']); ?>
					</div>
				<?php endif; ?>
		</div>
</html>
