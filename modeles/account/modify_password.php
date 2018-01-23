<?php

	$errors = [];

	if(!array_key_exists('password', $_POST) || !$_POST['password']) {
		$errors['password'] = "Veuillez renseigner votre Mot de Passe.";
	}
	if(!array_key_exists('newpassword', $_POST) || !$_POST['newpassword']) {
		$errors['newpassword'] = "Veuillez renseigner votre Nouveau Mot de Passe.";
	}
	if(!array_key_exists('cpassword', $_POST) || !$_POST['cpassword']) {
		$errors['cpassword'] = "Veuillez confirmer votre Mot de Passe.";
	}
	if (empty($errors)) {
		$password = hash('whirlpool', $_POST['password']);
		$newpassword = hash('whirlpool', $_POST['newpassword']);
		if($_SESSION['password'] != $password) {
			$errors['password'] = "Le mot de passe entré est incorrecte.";
		}
		else if($_POST['newpassword'] != $_POST['cpassword']) {
			$errors['password'] = "La confirmation de mot de passe ne correspond pas.";
		}
		else if($_SESSION['password'] === $newpassword) {
			$errors['password'] = "Veuillez entrer un mot de passe different.";
		}
	}

	if(!empty($errors)) {
		$_SESSION['errors'] = $errors;
		$_SESSION['inputs'] = $_POST;
	}
	else {
		if ($db = connect_db()) {
			$sql = "UPDATE Users SET password='".$newpassword."' WHERE id=".$_SESSION['id']."";
			$db -> query($sql);
			$_SESSION['password'] = $newpassword;
			$_SESSION['success'] = 1;
			//			$headers = 'FROM: dpaunovi@local.dev';
			$message = "Bonjour ".$_SESSION['login'].".\nNous vous confirmons la modification de votre ancien Mot de Passe.\n\nAncien Mot de Passe : ".$_POST['password']."\nVotre nouveau Mot de Passe : ".$_POST['newpassword']."";
			mail('draganpaunovic.charles@gmail.com', 'Modification de mot de passe', $message, $headers);
		}
	}
	header('location: /?module=settings&action=index');

?>
