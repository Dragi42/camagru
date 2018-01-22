<?php


	$errors = [];

	if(!array_key_exists('login', $_POST) || !$_POST['login']) {
		$errors['login'] = "Veuillez renseigner votre Login";
	}
	if(!array_key_exists('password', $_POST) || !$_POST['password']) {
		$errors['password'] = "Veuillez renseigner votre Mot de Passe";
	}
	if(!array_key_exists('mail', $_POST) || !$_POST['mail'] || !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
		$errors['mail'] = "Veuillez renseigner une adresse e-mail valide";
	}

	session_start();
	if(!empty($errors)) {
		$_SESSION['errors'] = $errors;
		$_SESSION['inputs'] = $_POST;
		header('location: /?module=auth&action=form');
	}
	else {
		$_SESSION['success'] = 1;
		$headers = 'FROM: dpaunovi@local.dev';
		mail('draganpaunovic.charles@gmail.com', 'Formulaire inscription', 'Création de compte', $headers);
		header('location: /?module=auth&action=form');
	}

?>
