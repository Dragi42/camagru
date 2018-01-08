<html>
	<head>
		<meta charset="utf-8">
		<meta content="Display Webcam Stream" name="title">
		<title>Camagru</title>
		<link rel="stylesheet" type="text/css" href="../style/index.css">
	</head>
	<body>
		<div class="box">
			<div class="container">
				<h2>Take or upload a Picture</h2>
				<div class="app">
					<a href="#" id="start-camera" class="visible">Touch here to start the app.</a>
					<video id="camera-stream"></video>
					<img id="snap"></img>
					<p id="error-message"></p>
					<form method="POST" action="./modeles/upload.php" enctype="mulitport/form-data" class="controls">
						<button href="#" id="delete-photo" title="Delete Photo" class="disabled"><i class="material-icons">delete</i></button>
						<button href="#" id="take-photo" type="hidden" title="Take Photo"><i class="material-icons">camera_alt</i></button>
						<button id="download-photo" type="submit" name="myimage" title="Save Photo" class="disabled"><i class="material-icons">file_download</i></button>
					</form>
					<canvas></canvas>
				</div>
<form method="POST" action="./modeles/upload.php" enctype="multipart/form-data">
 <input type="file" name="myimage">
 <input type="submit" name="submit_image" value="Upload">
</form>
			</div>
			<hr>
			<div class="container">
				<h2>History of Pictures</h2>
				<div class="gallery">
				<?php foreach ($images as $img) : ?>
					<div style='border: 2px solid black; margin: 10px; display: inline-block;'>
						<img src='<?= $img['path_img'] ?>' alt='' style='object-fit: cover;' width='300' height='200'/>
						<div style='padding: 10px; display: flex;'>
							<img src='./icons/like.ico' alt='likes' width='30' height='30'/><?= $img['like'] ?>
							<img src='./icons/comment.ico' alt='cemment' width='30' height='30'/><?= $img['comment'] ?>
						</div>
					</div>
				<?php endforeach; ?>
				</div>
			</div>
		</div>
		<script src="webcam.js"></script>
	</body>
</html>
