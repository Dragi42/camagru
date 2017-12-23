<?php

session_start();
if (!$_SESSION['logged_on_user'])
	header("location: index.php");
include("header.php");
?>

<html>
	<head>
		<meta charset="utf-8">
		<meta content="Display Webcam Stream" name="title">
		<title>Camagru</title>
		<link rel="stylesheet" type="text/css" href="css/index.css">
	</head>
		<div class="box">
			<div class="video">
				<h2>Take or upload a Picture</h2>
				<video autoplay="true" id="videoElement"></video>
			</div>
			<hr>
			<div class="history">
				<h2>History of Pictures</h2>
				<br />
				<div class="gallery">
		<?php
			include("./Database/db.php");
			include("./function.php");
			if ($db = connect_db()) {
				get_img($db, "where login='".$_SESSION['logged_on_user']."'");
			}
		?>
				</div>
			</div>
		</div>
		<div id="footer">
			<hr />
			<p>@2017 dpaunovi</p>
		</div>
		<script src="webcam.js"></script>
	</body>
</html>
