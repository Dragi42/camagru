<?php

	$errors = [];

	if(!array_key_exists('pwform-password', $_POST) || !$_POST['pwform-password']) {
		$errors['pwform-password'] = "Veuillez renseigner votre Mot de Passe.";
	}
	if(!array_key_exists('pwform-newpassword', $_POST) || !$_POST['pwform-newpassword']) {
		$errors['pwform-newpassword'] = "Veuillez renseigner votre Nouveau Mot de Passe.";
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
			$errors['pwform-password'] = "La confirmation de mot de passe ne correspond pas.";
		}
		else if($_SESSION['password'] === $newpassword) {
			$errors['pwform-password'] = "Veuillez entrer un mot de passe different.";
		}
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
			$sql = "UPDATE Users SET password='".$newpassword."' WHERE id=".$_SESSION['id']."";
			$db -> query($sql);
			$headers = 'FROM: dpaunovi@student.42.fr';
			$message = "Bonjour ".$_SESSION['pwform-login'].".\nNous vous confirmons la modification de votre ancien Mot de Passe.\n\nAncien Mot de Passe : ".$_POST['pwform-password']."\nVotre nouveau Mot de Passe : ".$_POST['pwform-newpassword']."";
			mail('draganpaunovic.charles@gmail.com', 'Modification de mot de passe', $message, $headers);
			$success['success'] = "Le changement de votre mot de passe à bien été effectué.\nNous vous avons envoyé un mail de confirmation.";
			$_SESSION['password'] = $newpassword;
			if (isAjax()) {
				header('Content-Type: application/json');
				echo json_encode($success);
				die();
			}
			$_SESSION['success'] = $success['success'];
		}
	}
	header('location: ./?module=settings&action=index');

?>
