<?php

	$errors = [];
	if(!$_GET['picture_id']) {
		$errors['picture_id'] = "Aucune photo n'est séléctionnée.";
		if (isAjax()) {
			header('Content-Type: application/json', true, 400);
			echo json_encode($errors);
			die();
		}
		$_SESSION['errors'] = $errors;
	}
	else {
		if ($db = connect_db()) {
			$query = $db->prepare("SELECT * FROM `Pictures` WHERE `id` = ?");
			$query->execute([$_GET['picture_id']]);
			$image = $query->fetch();
			if (!$image) {
				$errors['picture_id'] = "Cette photo n'existe pas.";
				if (isAjax()) {
					header('Content-Type: application/json', true, 400);
					echo json_encode($errors);
					die();
				}
				$_SESSION['errors'] = $errors;
			}
			else {
				$query = $db->prepare("SELECT * FROM `Comments` WHERE `picture_id` = ? ORDER by `id` desc");
				$query->execute([$_GET['picture_id']]);
				$comments = $query->fetchAll();
				aff_img($image);
				if (!$comments) {
					echo "<p class='content'>Il n'y a aucun commentaire actuellement sur cette photo.</p>";
				}
				else {
					foreach ($comments as $comment) {
						$query = $db->prepare("SELECT `login` FROM `Users` WHERE `id` = ?");
						$query->execute([$comment['user_id']]);
						$login = $query->fetch()['login'];
						echo "<h3 class='login'>".$login."</h3>
								<p class='content'>".$comment['content']."</p>";
					}
				}
/*				if (!$bool) {
					$query = "INSERT INTO `Likes` (`picture_id`,`user_id`) VALUES ('".$_POST['picture_id']."', '".$_SESSION['id']."')";
					$db->query($query);
					$req = $db->prepare("UPDATE Pictures SET `like` = `like` + 1 WHERE `id` = ?");
					$req->execute([$_POST['picture_id']]);
					$success['like'] = "Votre like à bien été pris en compte.";
					if (isAjax()) {
						header('Content-Type: application/json');
						echo json_encode($success);
						die();
					}
					$_SESSION['success'] = $success;
				}*/
			}
		}
	}
?>
