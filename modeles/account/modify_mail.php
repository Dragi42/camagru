<?php

	$errors = [];

	if(!array_key_exists('mail', $_POST) || !$_POST['mail']) {
		$errors['mail'] = "Veuillez entrer une adresse Mail.";
	}
	if(!array_key_exists('password', $_POST) || !$_POST['password']) {
		$errors['password'] = "Veuillez renseigner votre Mot de Passe.";
	}
	if(!array_key_exists('cpassword', $_POST) || !$_POST['cpassword']) {
		$errors['cpassword'] = "Veuillez confirmer votre Mot de Passe.";
	}
	if (empty($errors)) {
		$password = hash('whirlpool', $_POST['password']);
		if($_SESSION['mail'] === $_POST['mail']) {
			$errors['mail'] = "Veuillez entrer une adresse mail different.";
		}
		else if($_SESSION['password'] != $password) {
			$errors['password'] = "Le mot de passe entré est incorrecte.";
		}
		else if($_POST['password'] != $_POST['cpassword']) {
			$errors['password'] = "La confirmation de mot de passe ne correspond pas.";
		}
	}



	if(!empty($errors)) {
		$_SESSION['errors'] = $errors;
		$_SESSION['inputs'] = $_POST;
	}
	else {
		if ($db = connect_db()) {
			$query = $db->query("SELECT `mail` FROM Users WHERE mail='".$_POST['mail']."'");
			$exist = $query->fetch();
			if ($exist) {
				$errors['mail'] = "Cette adresse e-mail est déjà utilisé, merci d'en choisir une nouvelle.";
				$_SESSION['errors'] = $errors;
				$_SESSION['inputs'] = $_POST;
			}
			else {
				$sql = "UPDATE Users SET mail='".$_POST['mail']."' WHERE id=".$_SESSION['id']."";
				$db -> query($sql);
				//			$headers = 'FROM: dpaunovi@local.dev';
				$message = "L'adresse e-mail de votre compte à bien été changé en ".$_POST['mail'].".";
				mail('draganpaunovic.charles@gmail.com', 'Changement d\'adresse e-mail', $message, $headers);
				$_SESSION['success'] = "L'adresse e-mail de votre compte à bien été changé en ".$_POST['mail'].".";
				$_SESSION['mail'] = $_POST['mail'];
			}
		}
	}
	header('location: /?module=settings&action=index');

?>
