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
		$extend = ($_GET['action'] === 'extend') ? 1 : 0;
		if ($_SESSION['id']) {
			$query = $db->prepare("SELECT `picture_id`, `user_id` FROM `Likes` WHERE `picture_id` = ? AND `user_id` = ?");
			$query->execute([$img['id'], $_SESSION['id']]);
			$likeExist = $query->fetch();
			if ($likeExist) {
				$likeExist = "style='color: red;'";
				$likeico = "favorite";
			} else {
				$likeExist = '';
				$likeico = "favorite_border";
			}
		}
		else {
			$likeExist = '';
			$likeico = "favorite_border";
		}
		if ($img['comment'] > 0) {
			$commentico = "chat";
		} else {
			$commentico = "chat_bubble_outline";
		}
		if (!$extend) {
			echo "<div style='border: 2px solid black; margin: 10px; display: inline-block; height: 300px'>
					<form method='POST' style='padding: 10px;'>
						<button name='picture_id' formaction='./?module=images&action=extend&picture_id=".$img['id']."'><img src='".$img['path_img']."' alt='' style='object-fit: cover;'/></button>
						<div style='display: flex; justify-content: left;'>
							<button id='like-button' name='picture_id' value='".$img['id']."' formaction='./modules/images/like.php'><i class='material-icons' $likeExist>".$likeico."</i><p>".$img['like']."</p></button>
							<button id='comment-button' name='picture_id' formaction='./?module=images&action=extend&picture_id=".$img['id']."'><i class='material-icons'>".$commentico."</i><p>".$img['comment']."</p></button>
						</div>
					</form>
				</div>";
		}
		else {
			echo "<div class='container'>
					<img src='".$img['path_img']."' alt='' style='width: 90%;'/>
					<div class='container'>
						<form method='POST' style='padding: 10px;'>
							<div style='display: flex; justify-content: left;'>
								<button id='like-button' name='picture_id' value='".$img['id']."' formaction='./modules/images/like.php'><i class='material-icons' $likeExist>".$likeico."</i><p>".$img['like']."</p></button>
								<button id='comment-button' name='picture_id' formaction='./?module=images&action=extend&picture_id=".$img['id']."'><i class='material-icons'>".$commentico."</i><p>".$img['comment']."</p></button>";
								if ($img['user_id'] === $_SESSION['id']) {
									echo "<button id='delete-button' name='picture_id' formaction='./modules/images/delete.php?picture_id=".$img['id']."'><i class='material-icons'>delete_forever</i></button>";
								}
						echo	"</div>
						</form>
					</div>
					<hr style='border: 1px black solid;'>";

						get_com($img);

			echo "	<div>
						<form method='POST' action='./modules/images/comment.php?picture_id=".$img['id']."' style='padding: 10px; display: flex; flex-wrap: wrap; justify-content: center; flex-direction: column;'>
							<label>Votre commentaire</label>
							<textarea name='content' placeholder='Veuillez entrer votre commentaire' value=''></textarea>
							<button name='submit' type='submit' value='submit'>Envoyez</button>
						</form>
					</div>
				</div>
				</div>";
		}
	}

	function get_com($image) {
		$db = connect_db();
		if ($image) {
			$query = $db->prepare("SELECT * FROM `Comments` WHERE `picture_id` = ? ORDER by `id` desc");
			$query->execute([$image['id']]);
			$comments = $query->fetchAll();
			if (!$comments) {
				echo "<p class='content'>Il n'y a aucun commentaire actuellement sur cette photo.</p>";
			}
			else {
				foreach ($comments as $comment) {
					$query = $db->prepare("SELECT `login` FROM `Users` WHERE `id` = ?");
					$query->execute([$comment['user_id']]);
					$login = $query->fetch()['login'];
					if (!$login) {
						$query = $db->prepare("DELETE FROM `Comments` WHERE `user_id` = ?");
						$query->execute([$comment['user_id']]);
						$query = $db->prepare("UPDATE `Pictures` SET `comment` = `comment` - 1 WHERE `id` = ?");
						$query->execute([$image['id']]);
					}
					else {
						echo	"<div class='comment'>
									<h4 class='login'>".$login."</h4>
									<p class='content'>".$comment['content']."</p>
									<p class='date'>".$comment['date']."</p>
								</div><hr>";
					}
				}
			}
		}
	}


?>
