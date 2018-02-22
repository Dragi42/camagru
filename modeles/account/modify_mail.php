<?php

	$errors = [];

	if(!array_key_exists('mailform-mail', $_POST) || !$_POST['mailform-mail']) {
		$errors['mailform-mail'] = "Veuillez entrer une adresse Mail.";
	}
	if(!array_key_exists('mailform-password', $_POST) || !$_POST['mailform-password']) {
		$errors['mailform-password'] = "Veuillez renseigner votre Mot de Passe.";
	}
	if(!array_key_exists('mailform-cpassword', $_POST) || !$_POST['mailform-cpassword']) {
		$errors['mailform-cpassword'] = "Veuillez confirmer votre Mot de Passe.";
	}
	if (empty($errors)) {
		$password = hash('whirlpool', $_POST['mailform-password']);
		if($_SESSION['mail'] === $_POST['mailform-mail']) {
			$errors['mailform-mail'] = "Veuillez entrer une adresse mail different.";
		}
		else if($_POST['mailform-password'] != $_POST['mailform-cpassword']) {
			$errors['mailform-password'] = "La confirmation de mot de passe ne correspond pas.";
		}
		else if($_SESSION['password'] != $password) {
			$errors['mailform-password'] = "Le mot de passe entré est incorrecte.";
		}
	}
	if(!empty($errors)) {
		if (isAjax()) {
			header('Content-Type: application/json', true, 400);
			echo json_encode($errors);
			die();
		}
		$_SESSION['errors'] = $errors;
		$_SESSION['inputs'] = $_POST;
	}
	else {
		if ($db = connect_db()) {
			$query = $db->prepare("SELECT `mail` FROM Users WHERE mail = ?");
			$query->execute([$_POST['mailform-mail']]);
			$exist = $query->fetch();
			if ($exist) {
				$errors['mailform-mail'] = "Cette adresse e-mail est déjà utilisé, merci d'en choisir une nouvelle.";
				if (isAjax()) {
					header('Content-Type: application/json', true, 400);
					echo json_encode($errors);
					die();
				}
				$_SESSION['errors'] = $errors;
				$_SESSION['inputs'] = $_POST;
			}
			else {
				$query = $db->prepare("UPDATE Users SET mail = ? WHERE id = ?");
				$query->execute([$_POST['mailform-mail'], $_SESSION['id']]);
				$headers = 'FROM: dpaunovi@local.dev';
				$message = "L'adresse e-mail de votre compte à bien été changé en ".$_POST['mailform-mail'].".";
				mail($_POST['mailform-mail'], 'Changement d\'adresse e-mail', $message, $headers);
				mail($_SESSION['mail'], 'Changement d\'adresse e-mail', $message, $headers);
				$_SESSION['mail'] = $_POST['mailform-mail'];
				$success['success'] = "L'adresse e-mail de votre compte à bien été changé en ".$_POST['mailform-mail'].".";
				if (isAjax()) {
					header('Content-Type: application/json');
					echo json_encode($success);
					die();
				}
				$_SESSION['success'] = $success;
			}
		}
	}
	redirect();

?>
