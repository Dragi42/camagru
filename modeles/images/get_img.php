<?php

	function get_all_img() {
		$db = connect_db();
		$images = $db->query('SELECT `id`, `path_img`, `like`, `comment` FROM `Pictures` ORDER by `id` desc');
		foreach ($images as $img) {
			aff_img($img);
		}
	}

	function get_user_img() {
		$db = connect_db();
		$images = $db->query("SELECT `id`, `path_img`, `like`, `comment` FROM `Pictures` where user_id='".$_SESSION['id']."' ORDER by `id` desc");
		foreach ($images as $img) {
			aff_img($img);
		}
	}

	function aff_img($img) {
		$db = connect_db();
		if ($_SESSION['id']) {
				$query = $db->prepare("SELECT `picture_id`, `user_id` FROM `Likes` WHERE `picture_id` = ? AND `user_id` = ?");
				$query->execute([$img['id'], $_SESSION['id']]);
				$likeExist = $query->fetch();
				$query = $db->prepare("SELECT * FROM `Comments` WHERE `picture_id` = ?");
				$query->execute([$img['id']]);
				$commentExist = $query->fetch();
				if ($likeExist) {
					$likeExist = "style='color: red;'";
					$likeico = "favorite";
				} else {
					$likeExist = '';
					$likeico = "favorite_border";
				}

				if ($commentExist) {
					$commentico = "chat";
				} else {
					$commentico = "chat_bubble_outline";
				}
			}
			else {
				$likeExist = '';
				$likeico = "favorite_border";
			}
			echo "<div style='border: 2px solid black; margin: 10px; display: inline-block;'>
					<form method='POST' style='padding: 10px;'>
						<button name='picture_id' formaction='./?module=images&action=extend&picture_id=".$img['id']."'><img src='".$img['path_img']."' alt='' style='object-fit: cover;' width='300' height='200'/></button>
						<div style='display: flex; justify-content: left;'>
							<button id='like-button' name='picture_id' value='".$img['id']."' formaction='./modules/images/like.php'><i class='material-icons' $likeExist>".$likeico."</i><p>".$img['like']."</p></button>
							<button id='comment-button' name='picture_id' formaction='./?module=images&action=extend&picture_id=".$img['id']."'><i class='material-icons'>".$commentico."</i><p>".$img['comment']."</p></button>
						</div>
					</form>
				</div>";
	}

?>
