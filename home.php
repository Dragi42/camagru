<?php

include("header.php");
session_start();
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
				<video autoplay="true" id="videoElement">
				</video>
			<script>
				var video = document.querySelector("#videoElement");
				navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;
				if (navigator.getUserMedia) {
					navigator.getUserMedia({video: true}, handleVideo, videoError);
				}
				function handleVideo(stream) {
					video.src = window.URL.createObjectURL(stream);
				}
				function videoError(e) {
					// do something
				}
			</script>
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
	</body>
</html>

