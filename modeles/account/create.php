<?php

	$errors = [];

	if(!array_key_exists('cform-login', $_POST) || !$_POST['cform-login']) {
		$errors['cform-login'] = "Veuillez renseigner votre Login";
	}
	if(!array_key_exists('cform-password', $_POST) || !$_POST['cform-password']) {
		$errors['cform-password'] = "Veuillez renseigner votre Mot de Passe";
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
				$req ="
					INSERT INTO `Users` (`login`, `password`, `mail`) VALUES
				('" . $_POST['cform-login'] . "', '" . $_POST['cform-password'] . "', '" . $_POST['cform-mail'] . "');";
				$db -> query($req);
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
