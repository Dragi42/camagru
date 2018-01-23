<?php

	$errors = [];

	if(!array_key_exists('login', $_POST) || !$_POST['login']) {
		$errors['login'] = "Veuillez renseigner votre Login";
	}
	if(!array_key_exists('password', $_POST) || !$_POST['password']) {
		$errors['password'] = "Veuillez renseigner votre Mot de Passe";
	}

	if(!empty($errors)) {
		$_SESSION['errors'] = $errors;
		$_SESSION['inputs'] = $_POST;
	}
	else {
		if ($db = connect_db()) {
			$query = $db->prepare("SELECT `id`, `login`, `password` FROM Users WHERE `login` = ?");
			$query->execute([$_POST['login']]);
			$exist = $query->fetch();

			if(!$exist) {
				$errors['exist'] = "Le login utilisé n'existe pas";
				$_SESSION['errors'] = $errors;
			}
			else {
				$_POST['password'] = hash('whirlpool', $_POST['password']);
				if ($_POST['password'] != $exist['password']) {
					$errors['exist'] = "Mot de passe incorrect";
					$_SESSION['errors'] = $errors;
				}
				else {
					$_SESSION['id'] = $exist['id'];
					$_SESSION['login'] = $exist['login'];
					$_SESSION['password'] = $exist['password'];
					$_SESSION['logged'] = 1;
				}
			}
		}
	}
	header('location: /?module=account&action=index');

?>
