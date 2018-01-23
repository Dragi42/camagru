<html>
	<head>
		<meta charset='utf-8'>
		<link rel='stylesheet' type='text/css' href='../style/index.css'>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
		<meta name="viewport" content="width=device-width, initial-scale=0.7">
	</head>
	<body>
		<div id='header'>
			<div class='logo'>
				<a href='.'><h2>Camagru</h2></a>
			</div>
			<div class='navbar'>
				<ul class='list'>
<?php

	if ($_SESSION['id']) {
		echo "
					<li><a href='./?module=home&action=index' title='Home'>".$_SESSION['login']."</a></li>
					<li><a href='./' title='Accueil'>Accueil</a></li>
					<li><a href='./?module=settings&action=index' title='Settings'><i class='material-icons'>settings</i></a></li>
					<li><a href='./?module=account&action=logout' title='Log out'>Log out</a></li>
				</ul>
			</div>
		</div>
			";
	}

	else {
		echo "
					<li><a href='./?module=account&action=index'>Sign in / Sign up</a></li>
				</ul>
			</div>
		</div>
		<h1>Welcome to Camagru !</h1>
			";
	}

?>
	</body>
</html>
