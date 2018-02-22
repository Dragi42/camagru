<?php

	$errors = [];

	if(!array_key_exists('loginform-login', $_POST) || !$_POST['loginform-login']) {
		$errors['loginform-login'] = "Le champ Login n'est pas rempli correctement.";
	}
	else {
		if(strlen($_POST['loginform-login']) < 8 || strlen($_POST['loginform-login']) > 32)
			$errors['loginform-login'] = "Votre login doit contenir entre 8 et 16 caractère.";
		else {
			foreach (str_split($_POST['loginform-login']) as $row) {
				if (ctype_alpha($row) && !$text)
					$text = 1;
				else if (!ctype_alpha($row) && !ctype_digit($row))
					$errors['loginform-login'] = "Votre login ne peut pas contenir de caractère spéciaux.";
			}
			if (!$text)
				$errors['loginform-login1'] = "Votre Login doit contenir au moins une lettre.";
		}
	}
	if(!array_key_exists('loginform-password', $_POST) || !$_POST['loginform-password']) {
		$errors['loginform-password'] = "Veuillez renseigner votre Mot de Passe.";
	}
	if(!array_key_exists('loginform-cpassword', $_POST) || !$_POST['loginform-cpassword']) {
		$errors['loginform-cpassword'] = "Veuillez confirmer votre Mot de Passe.";
	}
	if (empty($errors)) {
		$password = hash('whirlpool', $_POST['loginform-password']);
		if($_SESSION['login'] === $_POST['loginform-login']) {
			$errors['loginform-login'] = "Veuillez entrer un login different.";
		}
		else if($_POST['loginform-password'] != $_POST['loginform-cpassword']) {
			$errors['loginform-cpassword'] = "La confirmation de mot de passe ne correspond pas.";
		}
		else if($_SESSION['password'] != $password) {
			$errors['loginform-password'] = "Le mot de passe entré est incorrecte.";
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
			$query = $db->prepare("SELECT `login` FROM Users WHERE login = ?");
			$query->execute([$_POST['loginform-login']]);
			$exist = $query->fetch();
			if ($exist) {
				$errors['loginform-login'] = "Ce Login est déjà utilisé, merci d'en choisir un nouveau.";
				if (isAjax()) {
					header('Content-Type: application/json', true, 400);
					echo json_encode($errors);
					die();
				}
				$_SESSION['errors'] = $errors;
				$_SESSION['inputs'] = $_POST;
			}
			else {
				$query = $db->prepare("UPDATE Users SET login = ? WHERE id = ?");
				$query->execute([$_POST['loginform-login'], $_SESSION['id']]);
				$headers = 'FROM: dpaunovi@local.dev';
				$message = "Bonjour ".$_SESSION['login'].".\nOu devrais-je dire... ".$_POST['loginform-login']."";
				mail($_SESSION['mail'], 'Nouveau Login', $message, $headers);
				$success['success'] = "Le login à bien été changé.\nVotre login sera desormais : ".$_POST['loginform-login']."";
				$_SESSION['login'] = $_POST['loginform-login'];
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
