<?php

	function get_all_img() {
		$db = connect_db();
		$images = $db->query('SELECT `id`, `path_img`, `like`, `comment` FROM `Pictures` ORDER by `id` desc');
		aff_img($images);
	}

	function get_user_img() {
		$db = connect_db();
		$images = $db->query("SELECT `id`, `path_img`, `like`, `comment` FROM `Pictures` where user_id='".$_SESSION['id']."' ORDER by `id` desc");
		aff_img($images);
	}

	function aff_img($images) {
		$db = connect_db();
		foreach ($images as $img) {
			if ($_SESSION['id']) {
				$query = $db->prepare("SELECT `picture_id`, `user_id` FROM `Likes` WHERE `picture_id` = ? AND `user_id` = ?");
				$query->execute([$img['id'], $_SESSION['id']]);
				$likeExist = $query->fetch();
				if ($likeExist) {
					$likeExist = "style='color: red;'";
				} else {
					$likeExist = '';
				}
			}
			echo "<div style='border: 2px solid black; margin: 10px; display: inline-block;'>
					<button name='path_img' value='1'><img src='".$img['path_img']."' alt='' style='object-fit: cover;' width='300' height='200'/></button>
					<form method='POST' style='padding: 10px; display: flex;'>
						<button id='like-button' name='picture_id' value='".$img['id']."' formaction='./?module=images&action=like'><i class='material-icons' $likeExist>favorite_border</i><p>".$img['like']."</p></button>
						<button id='comment-button' name='picture_id' value='".$img['id']."' formaction='./?module=images&action=comment'><i class='material-icons'>chat</i>".$img['comment']."</button>
					</form>
				</div>";
		}
	}

?>
