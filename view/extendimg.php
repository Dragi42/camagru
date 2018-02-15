<html>
	<head>
		<meta content="Display Webcam Stream" name="title">
		<title>Camagru</title>
	</head>
	<body>
			<?php if ($image) : ?>
			<?= aff_img($image); ?>
			<?php endif ?>
			<div class='container no-wrap extend'>
				<img src='<?php echo $image['path_img']; ?>' alt='' style="object-fit: scale-down; background: black;" width='70%'/>
				<div class='container'>
					<form method='POST' style='padding: 10px;'>
						<div style='display: flex; justify-content: left;'>
							<button id='like-button' name='picture_id' value='<?php echo $image['id']; ?>' formaction='./modules/images/like.php'><i class='material-icons' $likeExist>".$likeico."</i><p><?php echo $image['like']; ?></p></button>
							<button id='comment-button' name='picture_id' formaction='./?module=images&action=extend&picture_id=<?php echo $image['id']; ?>'><i class='material-icons'>".$commentico."</i><p><?php echo $image['comment']; ?></p></button>
						</div>
					</form>
					<?= get_com($image); ?>
				</div>
			</div>
<!--		<script src="./js/like.js"></script>-->
	</body>
</html>'
