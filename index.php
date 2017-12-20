<?php

	$db = new PDO('mysql:host=127.0.0.1', 'root', 'root');
	$db -> query('CREATE DATABASE camagru CHARACTER SET utf8;
					USE camagru;
					CREATE TABLE IF NOT EXISTS Users (
					id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
					login VARCHAR(32) NOT NULL,
					passwd VARCHAR(128) NOT NULL,
					mail VARCHAR(64) NOT NULL
					) ENGINE=InnoDB;');

	$req = $db -> query('SELECT * FROM pictures');
	

?>

<html>
	<head>
		<meta charset="utf-8">
		<meta content="Display Webcam Stream" name="title">
		<title>Camagru</title>
		<link rel="stylesheet" type="text/css" href="css/index.css">
	</head>
	<body>
		<div id="header">
			<div class="logo">
				<h2>Camagru</h2>
			</div>
			<div class="navbar">
				<ul class="list">
					<li><a href="login.php">Sign in / Sign up</a></li>
				</ul>
			</div>
		</div>
		<h1>Welcome to Camagru !</h1>
		<div class="box">
			<div class="history">
				<h2>All of Pictures</h2>
				<br />
				<div class="gallery">
					<img src="css/img/pic1.png" alt="" width="300" height="200"/>
					<img src="css/img/pic1.png" alt="" width="300" height="200"/>
					<img src="css/img/pic1.png" alt="" width="300" height="200"/>
					<img src="css/img/pic1.png" alt="" width="300" height="200"/>
				</div>
			</div>
		</div>
		<div id="footer">
			<hr />
			<p>@2017 dpaunovi</p>
		</div>
	</body>
</html>

