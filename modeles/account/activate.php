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
		$query = $db->prepare("SELECT `login`, `tstamp` FROM `Users` WHERE token = ?");
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
	
		if ($_SERVER["REQUEST_TIME"] - $tstamp > $delta && $row) {
			$errors['token'] = "Le token à expiré.";
			$query = $db->prepare("DELETE FROM `Users` WHERE login = ? AND token = ? AND tstamp = ?");
			$query->execute([$login, $token, $tstamp]);
		}
		else {
			$query = $db->prepare("UPDATE `Users` SET `token` = 1 WHERE `login` = ?");
			$query->execute([$login]);
			$success['token'] = "Votre compte à bien été activé.\nVous pouvez desormais vous connecter.";
		}

	// do one-time action here, like activating a user account
	}
	if (!empty($errors)) {
		$_SESSION['errors'] = $errors;
	}
	else {
		$_SESSION['success'] = $success;
	}
	header('location: ../../');

?>
