<?php

include("header.php");
session_start();
?>

<html>
	<head>
		<meta charset="utf-8">
		<title>Camagru</title>
		<link rel="stylesheet" type="text/css" href="css/index.css">
	</head>
	<body>
		<div class="box">
			<div class="history">
				<h2>All of Pictures</h2>
				<br />
				<div class="gallery">
<?php
	include("./Database/db.php");
	include("./function.php");
	if ($db = connect_db()) {
		get_img($db, "");
	}
?>
				</div>
			</div>
		</div>
		<div id="footer">
			<hr />
			<p>@2017 dpaunovi</p>
		</div>
	</body>
</html>
