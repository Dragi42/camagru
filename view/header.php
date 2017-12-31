<html>
	<head>
		<meta charset='utf-8'>
		<link rel='stylesheet' type='text/css' href='../style/index.css'>
	</head>
	<body>
		<div id='header'>
			<div class='logo'>
				<a href='../index.php'><h2>Camagru</h2></a>
			</div>
<?php

	if ($_SESSION['logged_on_user']) {
		echo "
			<div class='navbar'>
				<ul>
					<li><a href='home.php'>".$_SESSION['logged_on_user']."</a></li>
					<li><a href='index.php'>Accueil</a></li>
					<li><a href='Database/logout.php'>Log out</a></li>
				</ul>
			</div>
		</div>";
	}

	else {
		echo "
			<div class='navbar'>
				<ul class='list'>
					<li><a href='login.php'>Sign in / Sign up</a></li>
				</ul>
			</div>
		</div>
		<h1>Welcome to Camagru !</h1>";
	}

?>
	</body>
</html>
