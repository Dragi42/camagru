<?php

	$errors = [];

	if(!array_key_exists('form-password', $_POST) || !$_POST['form-password']) {
		$errors['form-password'] = "Veuillez renseigner votre Mot de Passe";
	}
	else {
		if(strlen($_POST['form-password']) < 8 || strlen($_POST['form-password']) > 16)
			$errors['form-password'] = "Votre Mot de Passe doit contenir entre 8 et 16 caractère.";
		else {
			foreach (str_split($_POST['form-password']) as $row) {
				if (ctype_alpha($row) && !$text)
					$text = 1;
				else if (ctype_digit($row) && !$digit)
					$digit = 1;
				else if (ctype_cntrl($row) || ctype_space($row))
					$errors['form-password'] = "Votre mot de passe ne peut pas contenir de caractère blanc ou non imprimable.";
				else if (!ctype_alpha($row) && !ctype_digit($row) && ctype_print($row) && !$special)
					$special = 1;
			}
			if (!$special || !$text || !$digit)
				$errors['form-password'] = "Votre Mot de Passe doit contenir au moins une lettre, un chiffre et un caractère spécial.";
		}
	}
	if(!array_key_exists('form-cpassword', $_POST) || !$_POST['form-cpassword']) {
		$errors['form-cpassword'] = "Veuillez confirmer votre Mot de Passe.";
	}
	else if($_POST['form-cpassword'] != $_POST['form-password']) {
		$errors['form-cpassword'] = "La confirmation du Mot de Passe ne correspond pas.";
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
			$_POST['form-password'] = hash('whirlpool', $_POST['form-password']);
			$query = $db->prepare("SELECT `mail` FROM `Users` WHERE `pwtoken` = ?");
			$query->execute([$_GET['token']]);
			$mail = $query->fetch()['mail'];
			$query = $db->prepare("UPDATE `Users` SET `password` = ?, `pwtoken` = ?, `pwtstamp` = ? WHERE `pwtoken` = ?");
			$query->execute([$_POST['form-password'], 0, 0, $_GET['token']]);
			$success['success'] = "Votre mot de passe vient d'etre modifié avec succes.";
			$headers = 'FROM: dpaunovi@local.dev';
			$url = 'http://localhost:8080/?module=account&action=log';
			$message = 'Your password has succesfully modified.
				You can connect on our website now: '.$url.'';
			mail($mail, 'Password modified', $message, $headers);
			$_SESSION['success'] = $success;
		}
	}
	if ($_SESSION['success'])
		header('location: ../../?module=account&action=log');
	else
		redirect();

?>
