<?php

	$errors = [];
	if(!$_POST['picture_id']) {
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
			$query = $db->prepare("SELECT `id` FROM `Pictures` WHERE `id` = ?");
			$query->execute([$_POST['picture_id']]);
			if (!$query->fetch()) {
				$errors['picture_id'] = "Cette photo n'existe pas.";
				if (isAjax()) {
					header('Content-Type: application/json', true, 400);
					echo json_encode($errors);
					die();
				}
				$_SESSION['errors'] = $errors;
			}
			else {
				$query = $db->prepare("SELECT `user_id` FROM `Likes` WHERE `picture_id` = ?");
				$query->execute([$_POST['picture_id']]);
				$exist = $query->fetchAll();
				for ($i = 0; $i < count($exist); $i++) {
					if ($exist[$i][0] === $_SESSION['id']) {
						$query = $db->prepare("DELETE FROM `Likes` WHERE `picture_id` = ? AND `user_id` = ?");
						$query->execute([$_POST['picture_id'], $_SESSION['id']]);
						$query = $db->prepare("UPDATE Pictures SET `like` = `like` - 1 WHERE `id` = ?");
						$query->execute([$_POST['picture_id']]);
						$success['dislike'] = "Votre like à bien été retiré.";
						if (isAjax()) {
							header('Content-Type: application/json');
							echo json_encode($success);
							die();
						}
						$_SESSION['success'] = $success;
						$bool = TRUE;
					}
				}
				if (!$bool) {
					$query = $db->prepare("INSERT INTO `Likes` (`picture_id`,`user_id`) VALUES (?, ?)");
					$query->execute([$_POST['picture_id'], $_SESSION['id']]);
					$query = $db->prepare("UPDATE Pictures SET `like` = `like` + 1 WHERE `id` = ?");
					$query->execute([$_POST['picture_id']]);
					$success['like'] = "Votre like à bien été pris en compte.";
					if (isAjax()) {
						header('Content-Type: application/json');
						echo json_encode($success);
						die();
					}
					$_SESSION['success'] = $success;
				}
			}
		}
	}
	header("location: ".$_SERVER['HTTP_REFERER']."");
?>
