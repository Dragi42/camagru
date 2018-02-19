<?php

	$errors = [];

	if(!array_key_exists('lform-login', $_POST) || !$_POST['lform-login']) {
		$errors['lform-login'] = "Veuillez renseigner votre Login";
	}
	if(!array_key_exists('lform-password', $_POST) || !$_POST['lform-password']) {
		$errors['lform-password'] = "Veuillez renseigner votre Mot de Passe";
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
			$query = $db->prepare("SELECT `id`, `login`, `password`, `mail` FROM Users WHERE `login` = ?");
			$query->execute([$_POST['lform-login']]);
			$exist = $query->fetch();

			if(!$exist) {
				$errors['lform-login'] = "Le login utilisé n'existe pas";
				if (isAjax()) {
					header('Content-Type: application/json', true, 400);
					echo json_encode($errors);
					die();
				}
				$_SESSION['errors'] = $errors;
			}
			else {
				$_POST['lform-password'] = hash('whirlpool', $_POST['lform-password']);
				if ($_POST['lform-password'] != $exist['password']) {
					$errors['lform-password'] = "Mot de passe incorrect";
					if (isAjax()) {
						header('Content-Type: application/json', true, 400);
						echo json_encode($errors);
						die();
					}
					$_SESSION['errors'] = $errors;
				}
				else {
					$success['success'] = "Connection effectuée.";
					$_SESSION['id'] = $exist['id'];
					$_SESSION['login'] = $exist['login'];
					$_SESSION['password'] = $exist['password'];
					$_SESSION['mail'] = $exist['mail'];
					$_SESSION['success'] = $success;
					$_SESSION['logged'] = 1;
					unset($_SESSION['lastpage']);
					header("location: ../../?".$_SERVER['QUERY_STRING']."");
					die();
				}
			}
		}
	}
	header("location: ../../?module=account&action=index");
?>
