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
			<div class="container">
				<h2>Take or upload a Picture</h2>
				<div class="app">
					<a href="#" id="start-camera" class="visible">Touch here to start the app.</a>
					<video id="camera-stream"></video>
					<img id="snap">
					<p id="error-message"></p>
					<div class="controls">
						<a href="#" id="delete-photo" title="Delete Photo" class="disabled"><i class="material-icons">delete</i></a>
						<a href="#" id="take-photo" title="Take Photo"><i class="material-icons">camera_alt</i></a>
						<a href="#" id="download-photo" download="selfie.png" title="Save Photo" class="disabled"><i class="material-icons">file_download</i></a>
					</div>
					<canvas></canvas>
				</div>
			</div>
			<hr>
			<div class="container">
				<h2>History of Pictures</h2>
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
