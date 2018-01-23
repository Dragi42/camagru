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

	if(!empty($errors)) {
		$_SESSION['errors'] = $errors;
		$_SESSION['inputs'] = $_POST;
	}
	else {
		if ($db = connect_db()) {
			$query = $db->prepare("SELECT `login`, `mail` FROM Users WHERE `login` = ? OR `mail` = ?;");
			$query->execute([$_POST['login'], $_POST['mail']]);
			$exist = $query->fetch();

			if($exist) {
				if ($exist['login'] == $_POST['login']) {
					$errors['exist'] = "Le login existe déjà, veuillez en choisir un nouveau";
				}
				else {
					$errors['exist'] = "Cette adresse e-mail est déjà utilisée";
				}
				$_SESSION['errors'] = $errors;
				$_SESSION['inputs'] = $_POST;
			}
			else {
				$_POST['password'] = hash('whirlpool', $_POST['password']);
				$req ="
					INSERT INTO `Users` (`login`, `password`, `mail`) VALUES
				('" . $_POST['login'] . "', '" . $_POST['password'] . "', '" . $_POST['mail'] . "');";
				$db -> query($req);
				$_SESSION['success'] = 1;
//				$headers = 'FROM: dpaunovi@local.dev';
				mail('draganpaunovic.charles@gmail.com', 'Formulaire inscription', 'Création de compte', $headers);
			}
		}
	}
	header('location: /?module=account&action=index');

?>
