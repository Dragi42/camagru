<?php

	function isAjax() {
		return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}	

	$errors = [];

	if(!array_key_exists('login', $_POST) || !$_POST['login']) {
		$errors['login'] = "Veuillez entrer un Nouveau Login.";
	}
	if(!array_key_exists('password', $_POST) || !$_POST['password']) {
		$errors['password'] = "Veuillez renseigner votre Mot de Passe.";
	}
	if(!array_key_exists('cpassword', $_POST) || !$_POST['cpassword']) {
		$errors['cpassword'] = "Veuillez confirmer votre Mot de Passe.";
	}
	if (empty($errors)) {
		$password = hash('whirlpool', $_POST['password']);
		if($_SESSION['login'] === $_POST['login']) {
			$errors['login'] = "Veuillez entrer un login different.";
		}
		else if($_POST['password'] != $_POST['cpassword']) {
			$errors['password'] = "La confirmation de mot de passe ne correspond pas.";
		}
		else if($_SESSION['password'] != $password) {
			$errors['password'] = "Le mot de passe entré est incorrecte.";
		}
	}


	if(!empty($errors)) {
		if (isAjax()) {
			http_response_code(400);
			header('Content-Type: application/json');
			echo json_encode($errors);
			die();
		}
		$_SESSION['errors'] = $errors;
		$_SESSION['inputs'] = $_POST;
	}
	else {
		if ($db = connect_db()) {
			$query = $db->query("SELECT `login` FROM Users WHERE login='".$_POST['login']."'");
			$exist = $query->fetch();
			if ($exist) {
				$errors['login'] = "Ce Login est déjà utilisé, merci d'en choisir un nouveau.";
				$_SESSION['errors'] = $errors;
				$_SESSION['inputs'] = $_POST;
			}
			else {
				$sql = "UPDATE Users SET login='".$_POST['login']."' WHERE id=".$_SESSION['id']."";
				$db -> query($sql);
				$headers = 'FROM: dpaunovi@student.42.fr';
				$message = "Bonjour ".$_SESSION['login'].".\nOu devrais-je dire... ".$_POST['login']."";
				mail('draganpaunovic.charles@gmail.com', 'Nouveau Login', $message, $headers);
				$_SESSION['success'] = "Le login à bien été changé.\nVotre login sera desormais : ".$_POST['login']."";
				$_SESSION['login'] = $_POST['login'];
			}
		}
	}
//	header('location: ../../?module=settings&action=index');

?>
