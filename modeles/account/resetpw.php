<?php

	//	Retrieve token

	if (isset($_GET["token"]) && preg_match('/^[0-9A-F]{40}$/i', $_GET["token"])) {
		$token = $_GET["token"];
	}
	else {
		$errors['token'] = "Ce token n'est pas valide.";
	}
	if ($db = connect_db()) {

	//	Verify token

		$query = $db->prepare("SELECT `login`, `pwtstamp` FROM `Users` WHERE pwtoken = ?");
		$query->execute([$token]);
		$row = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();

		if ($row) {
			extract($row);
			$delta = 86400;
		}
		else {
			$errors['token'] = "Ce token n'existe pas.";
		}
	
		//  delete token so it can't be used again
	
		if ($_SERVER["REQUEST_TIME"] - $pwtstamp > $delta && $row) {
			$errors['token'] = "Le token à expiré.";
		}
		else {
			$success['token'] = "Veuillez entrer votre nouveau mot de passe.";
		}

	// do one-time action here, like activating a user account
	}
	if (!empty($errors)) {
		$_SESSION['errors'] = $errors;
		require './view/log.php';
	}
	else {
		$_SESSION['success'] = $success;
		require './view/resetpw.php';
	}

?>
