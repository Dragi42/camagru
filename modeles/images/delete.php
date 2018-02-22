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
			$query = $db->prepare("SELECT `user_id` FROM `Pictures` WHERE `id` = ?");
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
				if ($image['user_id'] === $_SESSION['id']) {
					$query = $db->prepare("DELETE FROM `Pictures` WHERE `id` = ?");
					$query->execute([$_GET['picture_id']]);
					$query = $db->prepare("DELETE FROM `Likes` WHERE `picture_id` = ?");
					$query->execute([$_GET['picture_id']]);
					$query = $db->prepare("DELETE FROM `Comments` WHERE `picture_id` = ?");
					$query->execute([$_GET['picture_id']]);
					$success['delete'] = "Votre photo a bien été supprimée.";
					if (isAjax()) {
						header('Content-Type: application/json');
						echo json_encode($success);
						die();
					}
					$_SESSION['success'] = $success;
				}
				else {
					$errors['picture_id'] = "Vous ne pouvez pas supprimer cette photo car elle ne vous appartient pas.";
					if (isAjax()) {
						header('Content-Type: application/json', true, 400);
						echo json_encode($errors);
						die();
					}
					$_SESSION['errors'] = $errors;
				}
			}
		}
	}
	header('location: ../../?module=home');
?>
