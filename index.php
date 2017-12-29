<?php

include("header.php");
	include("./function.php");
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
		<div class="container">
			<h2>All of Pictures</h2>
			<iframe src="https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2FLADbible%2Fvideos%2F4308500969197060%2F&show_text=0&width=476" style="max-width: 50%; max-height: 50%; min-width: 300px; min-height: 300px;" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allowFullScreen="true"></iframe>
			<br />
			<h2>Merry Christmas mader faker</h2>
			<div class="gallery">
<?php
		get_img($db, "ORDER BY `id` desc");
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
