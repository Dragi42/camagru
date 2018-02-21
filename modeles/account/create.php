<?php

	$errors = [];

	if(!array_key_exists('cform-login', $_POST) || !$_POST['cform-login']) {
		$errors['cform-login'] = "Veuillez renseigner votre Login";
	}
	else {
		if(strlen($_POST['cform-login']) < 8 || strlen($_POST['cform-login']) > 32)
			$errors['cform-login'] = "Votre login doit contenir entre 8 et 16 caractère.";
		else {
			foreach (str_split($_POST['cform-login']) as $row) {
				if (ctype_alpha($row) && !$text)
					$text = 1;
				else if (!ctype_alpha($row) && !ctype_digit($row))
					$errors['cform-login'] = "Votre login ne peut pas contenir de caractère spéciaux.";
			}
			if (!$text)
				$errors['cform-login1'] = "Votre Login doit contenir au moins une lettre.";
		}
	}
	if(!array_key_exists('cform-password', $_POST) || !$_POST['cform-password']) {
		$errors['cform-password'] = "Veuillez renseigner votre Mot de Passe";
	}
	else {
		if(strlen($_POST['cform-password']) < 8 || strlen($_POST['cform-password']) > 16)
			$errors['cform-password'] = "Votre Mot de Passe doit contenir entre 8 et 16 caractère.";
		else {
			foreach (str_split($_POST['cform-password']) as $row) {
				if (ctype_alpha($row) && !$text)
					$text = 1;
				else if (ctype_digit($row) && !$digit)
					$digit = 1;
				else if (ctype_cntrl($row) || ctype_space($row))
					$errors['cform-password'] = "Votre mot de passe ne peut pas contenir de caractère blanc ou non imprimable.";
				else if (!ctype_alpha($row) && !ctype_digit($row) && ctype_print($row) && !$special)
					$special = 1;
			}
			if (!$special || !$text || !$digit)
				$errors['cform-password1'] = "Votre Mot de Passe doit contenir au moins une lettre, un chiffre et un caractère spécial.";
		}
	}
	if(!array_key_exists('cform-mail', $_POST) || !$_POST['cform-mail'] || !filter_var($_POST['cform-mail'], FILTER_VALIDATE_EMAIL)) {
		$errors['cform-mail'] = "Veuillez renseigner une adresse e-mail valide";
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
			$_POST['cform-login'] = strtolower($_POST['cform-login']);
			$query = $db->prepare("SELECT `login`, `mail` FROM Users WHERE `login` = ? OR `mail` = ?;");
			$query->execute([$_POST['cform-login'], $_POST['cform-mail']]);
			$exist = $query->fetch();

			if($exist) {
				if ($exist['login'] == $_POST['cform-login']) {
					$errors['cform-login'] = "Le login existe déjà, veuillez en choisir un nouveau";
				}
				else {
					$errors['cform-mail'] = "Cette adresse e-mail est déjà utilisée";
				}
				if (isAjax()) {
					header('Content-Type: application/json', true, 400);
					echo json_encode($errors);
					die();
				}
				$_SESSION['errors'] = $errors;
				$_SESSION['inputs'] = $_POST;
			}
			else {
				$_POST['cform-password'] = hash('whirlpool', $_POST['cform-password']);
				$query = $db->prepare("INSERT INTO `Users` (`login`, `password`, `mail`) VALUES (?, ?, ?)");
				$query->execute([$_POST['cform-login'], $_POST['cform-password'], $_POST['cform-mail']]);
				$success['success'] = "Votre compte à bien été créé et un mail de confirmation vient de vous etre envoyé.";
				$headers = 'FROM: dpaunovi@local.dev';
				mail('draganpaunovic.charles@gmail.com', 'Formulaire inscription', 'Création de compte', $headers);
				if (isAjax()) {
					header('Content-Type: application/json');
					echo json_encode($success);
					die();
				}
				$_SESSION['success'] = $success;
			}
		}
	}
	header('location: /?module=account&action=index');

?>
