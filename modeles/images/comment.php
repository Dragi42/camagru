<?php

	$errors = [];
	$_POST['picture_id'] = $_GET['picture_id'];
	if(!$_POST['picture_id']) {
		$errors['picture_id'] = "Aucune photo n'est séléctionnée.";
		if (isAjax()) {
			header('Content-Type: application/json');
			echo json_encode($errors);
			die();
		}
		$_SESSION['errors'] = $errors;
	}
	else if(!$_POST['content']) {
		$errors['content'] = "Veuillez entrer un commentaire.";
		if (isAjax()) {
			header('Content-Type: application/json');
			echo json_encode($errors);
			die();
		}
		$_SESSION['errors'] = $errors;
	}
	else if(ctype_space($_POST['content'])) {
		$errors['content'] = "Veuillez entrer un commentaire valide...";
		if (isAjax()) {
			header('Content-Type: application/json');
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
					header('Content-Type: application/json');
					echo json_encode($errors);
					die();
				}
				$_SESSION['errors'] = $errors;
			}
			else {
				$query = $db->prepare("INSERT INTO `Comments` (`picture_id`,`user_id`, `content`) VALUES (?, ?, ?)");
				$query->execute([$_POST['picture_id'], $_SESSION['id'], htmlspecialchars($_POST['content'])]);
				$req = $db->prepare("UPDATE Pictures SET `comment` = `comment` + 1 WHERE `id` = ?");
				$req->execute([$_POST['picture_id']]);
				if ($user['user_id'] && $user['user_id'] != $_SESSION['id']) {
					$query = $db->prepare("SELECT `mail`, `notification` FROM `Users` WHERE `id` = ?");
					$query->execute([$user['user_id']]);
					$user = $query->fetch();
					if ($user['mail'] && $user['notification']) {
						$headers = 'FROM: dpaunovi@local.dev';
						$message = 'Bonjour, l\'utilisateur '.strtoupper($_SESSION['login']).' à commenté votre photo !
									Voici le lien de redirection vers votre poste : '.$_SERVER['HTTP_REFERER'];
						mail($user['mail'], 'Votre photo a été commentée.', $message, $headers);
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
