<html>
	<head>
		<meta content="Display Webcam Stream" name="title">
		<title>Camagru</title>
	</head>
	<body>
		<div class="box">
			<div class="container">

				<h2>Take or upload a Picture</h2>
				<div class="app">
					<a href="#" id="start-camera" class="visible">Touch here to start the app.</a>
					<a href="#" id="start-upload" class="visible">Touch here to upload a picture.</a>
					<video id="camera-stream"></video>
					<img id="snap"></img>
					<p id="error-message"></p>
					<form method="POST" action="./modeles/images/upload.php" id="webcam-form" enctype="mulitport/form-data" class="controls">
						<button id="delete-photo" title="Delete Photo" class="disabled"><i class="material-icons">delete</i></button>
						<button id="take-photo" type="hidden" title="Take Photo"><i class="material-icons">camera_alt</i></button>
						<button id="download-photo" type="submit" name="myimage" title="Save Photo" class="disabled"><i class="material-icons">file_download</i></button>
					</form>
					<canvas></canvas>
				</div>
				<form method="POST" id="upload-form" action="./modeles/images/upload.php" enctype="multipart/form-data">
					<input type="file" name="img">
					<input type="submit" name="submit">
				</form>
			</div>
			<hr>
			<div class="container">
				<h2>History of Pictures</h2>
				<div class="gallery">
				<?php get_user_img(); ?>
				</div>
			</div>
		</div>
		<script src="./js/webcam.js"></script>
	</body>
</html>
