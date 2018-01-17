<html>
	<head>
		<meta charset="utf-8">
		<title>Camagru</title>
	</head>
	<body>
	<div class="box">
		<div class="container">
			<h2>All of Pictures</h2>
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
	</body>
</html>
