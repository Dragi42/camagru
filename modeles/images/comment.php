<?php

	$errors = [];
	$_POST['picture_id'] = $_GET['picture_id'];
	if(!$_POST['picture_id']) {
		$errors['picture_id'] = "Aucune photo n'est séléctionnée.";
		if (isAjax()) {
			header('Content-Type: application/json', true, 400);
			echo json_encode($errors);
			die();
		}
		$_SESSION['errors'] = $errors;
	}
	else if(!$_POST['content']) {
		$errors['content'] = "Veuillez entrer un commentaire.";
		if (isAjax()) {
			header('Content-Type: application/json', true, 400);
			echo json_encode($errors);
			die();
		}
		$_SESSION['errors'] = $errors;
	}
	else {
		if ($db = connect_db()) {
			$query = $db->prepare("SELECT `id`, `user_id` FROM `Pictures` WHERE `id` = ?");
			$query->execute([$_POST['picture_id']]);
			$user = $query->fetch();
			if (!$user) {
				$errors['picture_id'] = "Cette photo n'existe pas.";
				if (isAjax()) {
					header('Content-Type: application/json', true, 400);
					echo json_encode($errors);
					die();
				}
				$_SESSION['errors'] = $errors;
			}
			else {
				$query = $db->prepare("INSERT INTO `Comments` (`picture_id`,`user_id`, `content`) VALUES (?, ?, ?)");
				$query->execute([$_POST['picture_id'], $_SESSION['id'], $_POST['content']]);
				$req = $db->prepare("UPDATE Pictures SET `comment` = `comment` + 1 WHERE `id` = ?");
				$req->execute([$_POST['picture_id']]);
				if ($user['user_id'] && $user['user_id'] != $_SESSION['id']) {
					$query = $db->prepare("SELECT `mail`, `notification` FROM `Users` WHERE `id` = ?");
					$query->execute([$user['user_id']]);
					$user = $query->fetch();
					if ($user['mail'] && $user['notification']) {
						$headers = 'FROM: dpaunovi@local.dev';
						mail($user['mail'], 'Votre photo a été commentée.', 'Bonjour, l\'utilisateur '.$_SESSION['login'].' å commenté votre photo !\nVoici le lien de redirection :'.$_SERVER['HTTP_REFERER'], $headers);
					}
				}
				$success['comment'] = "Votre commentaire à bien été pris en compte.";
				if (isAjax()) {
					header('Content-Type: application/json');
					echo json_encode($success);
					die();
				}
				$_SESSION['success'] = $success;
			}
		}
	}
	header("location: ".$_SERVER['HTTP_REFERER']."");
?>
