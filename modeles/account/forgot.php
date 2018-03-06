<?php

	$errors = [];

	if(!array_key_exists('form-login', $_POST) || !$_POST['form-login']) {
		$errors['form-login'] = "Le champ Login n'est pas rempli correctement.";
	}
	if(!array_key_exists('form-mail', $_POST) || !$_POST['form-mail']) {
		$errors['form-mail'] = "Le champ Mail n'est pas rempli correctement.";
	}
	if (!empty($errors)) {
		if (isAjax()) {
			header('Content-Type: application/json');
			echo json_encode($errors);
			die();
		}
		$_SESSION['errors'] = $errors;
	}
	else {
		if ($db = connect_db()) {
			$query = $db->prepare("SELECT `login`, `mail` FROM Users WHERE login = ?");
			$query->execute([$_POST['form-login']]);
			$exist = $query->fetch();
			if (!$exist) {
				$errors['form-login'] = "Ce Login n'existe pas, merci d'en choisir un nouveau.";
				if (isAjax()) {
					header('Content-Type: application/json');
					echo json_encode($errors);
					die();
				}
				$_SESSION['errors'] = $errors;
			}
			else {
				if ($exist['mail'] != $_POST['form-mail']) {
					$errors['form-mail'] = "L'adresse mail ne correspond pas a l'adresse utilisée pour ce login.";
					if (isAjax()) {
						header('Content-Type: application/json');
						echo json_encode($errors);
						die();
					}
					$_SESSION['errors'] = $errors;
				}
				else {	// Reinitialisation du mot de passe.

/*					$query = $db->prepare("UPDATE Users SET login = ? WHERE id = ?");
					$query->execute([$_POST['loginform-login'], $_SESSION['id']]);
					$headers = 'FROM: dpaunovi@local.dev';
					$message = "Bonjour ".$_SESSION['login'].".\nOu devrais-je dire... ".$_POST['loginform-login']."";
					mail($_SESSION['mail'], 'Nouveau Login', $message, $headers);*/
					$token = sha1(uniqid($_POST['form-login'], true));
					$success['success'] = "Un mail de reinitialisation de mot de passe vient de vous etre envoyé à <br>'".$_POST['form-mail']."' Concernant le compte : ".$_POST['form-login']." .";
					$query = $db->prepare("UPDATE `Users` SET `pwtstamp` = ?, `pwtoken` = ? WHERE `login` = ?");
					$query->execute([$_SERVER["REQUEST_TIME"], $token, $_POST['form-login']]);
					$headers = 'FROM: dpaunovi@local.dev';
					$url = $_SERVER['HTTP_ORIGIN']."?module=account&action=resetpw&token=".$token;		// /modules/account/resetpw.php?token='.$token;
					$message = 'Suite à votre demande de reinitialisation de mot de passe, veuillez cliquer sur le lien suivant : '.$url.'.';
					mail($_POST['form-mail'], 'Reset password', $message, $headers);
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
	redirect();

?>
