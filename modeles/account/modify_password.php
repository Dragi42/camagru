<?php

	$errors = [];

	if(!array_key_exists('pwform-password', $_POST) || !$_POST['pwform-password']) {
		$errors['pwform-password'] = "Veuillez renseigner votre Mot de Passe.";
	}
	if(!array_key_exists('pwform-newpassword', $_POST) || !$_POST['pwform-newpassword']) {
		$errors['pwform-newpassword'] = "Veuillez renseigner votre Nouveau Mot de Passe.";
	}
	else {
		if(strlen($_POST['pwform-newpassword']) < 8 || strlen($_POST['pwform-newpassword']) > 16)
			$errors['pwform-newpassword'] = "Votre Mot de Passe doit contenir entre 8 et 16 caractère.";
		else {
			foreach (str_split($_POST['pwform-newpassword']) as $row) {
				if (ctype_alpha($row) && !$text)
					$text = 1;
				else if (ctype_digit($row) && !$digit)
					$digit = 1;
				else if (ctype_cntrl($row) || ctype_space($row))
					$errors['pwform-newpassword'] = "Votre mot de passe ne peut pas contenir de caractère blanc ou non imprimable.";
				else if (!ctype_alpha($row) && !ctype_digit($row) && ctype_print($row) && !$special)
					$special = 1;
			}
			if (!$special || !$text || !$digit)
				$errors['pwform-newpassword1'] = "Votre Mot de Passe doit contenir au moins une lettre, un chiffre et un caractère spécial.";
		}
	}
	if(!array_key_exists('pwform-cpassword', $_POST) || !$_POST['pwform-cpassword']) {
		$errors['pwform-cpassword'] = "Veuillez confirmer votre Nouveau Mot de Passe.";
	}
	if (empty($errors)) {
		$password = hash('whirlpool', $_POST['pwform-password']);
		$newpassword = hash('whirlpool', $_POST['pwform-newpassword']);
		if($_SESSION['password'] != $password) {
			$errors['pwform-password'] = "Le mot de passe entré est incorrecte.";
		}
		else if($_POST['pwform-newpassword'] != $_POST['pwform-cpassword']) {
			$errors['pwform-cpassword'] = "La confirmation de mot de passe ne correspond pas.";
		}
		else if($_SESSION['password'] === $newpassword) {
			$errors['pwform-newpassword'] = "Veuillez entrer un mot de passe different.";
		}
	}

	if(!empty($errors)) {
		if (isAjax()) {
			header('Content-Type: application/json');
			echo json_encode($errors);
			die();
		}
		$_SESSION['errors'] = $errors;
		$_SESSION['inputs'] = $_POST;
	}
	else {
		if ($db = connect_db()) {
			$query = $db->prepare("UPDATE Users SET password = ? WHERE id = ?");
			$query->execute([$newpassword, $_SESSION['id']]);
			$headers = 'FROM: dpaunovi@local.dev';
			$message = "Bonjour ".$_SESSION['pwform-login'].".\nNous vous confirmons la modification de votre ancien Mot de Passe.";
			mail($_SESSION['mail'], 'Modification de mot de passe', $message, $headers);
			$_SESSION['password'] = $newpassword;
			$success['success'] = "Le changement de votre mot de passe à bien été effectué.\nNous vous avons envoyé un mail de confirmation.";
			if (isAjax()) {
				header('Content-Type: application/json');
				echo json_encode($success);
				die();
			}
			$_SESSION['success'] = $success;
		}
	}
	redirect();

?>
