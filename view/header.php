<html>
	<head>
		<meta charset='utf-8'>
		<link rel='stylesheet' type='text/css' href='../style/index.css'>
	</head>
	<body>
		<div id='header'>
			<div class='logo'>
				<a href='.'><h2>Camagru</h2></a>
			</div>
			<div class='navbar'>
				<ul class='list'>
<?php

	if ($_SESSION['logged_on_user']) {
		echo "
					<li><a href='./?module=login&action=home'>".$_SESSION['logged_on_user']."</a></li>
					<li><a href='./'>Accueil</a></li>
					<li><a href='./?module=auth&action=logout'>Log out</a></li>
				</ul>
			</div>
		</div>
			";
	}

	else {
		echo "
					<li><a href='./?module=auth&action=form'>Sign in / Sign up</a></li>
				</ul>
			</div>
		</div>
		<h1>Welcome to Camagru !</h1>
			";
	}

?>
	</body>
</html>
