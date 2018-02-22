<?php

	$errors = [];

	if ($db = connect_db()) {
		if ($_SESSION['notification'] === 1) {
			$query = $db->prepare("UPDATE Users SET notification = ? WHERE id = ?");
			$query->execute([0, $_SESSION['id']]);
			$headers = 'FROM: dpaunovi@local.dev';
			$message = "Bonjour ".$_SESSION['login'].".\nLa désactivation des notifications vient d'etre effectué avec succes.";
			mail($_SESSION['mail'], 'Notification', $message, $headers);
			$success['success'] = "Les notifications ont bien été désactivées.";
			$_SESSION['notification'] = 0;
		}
		else {
			$query = $db->prepare("UPDATE Users SET notification = ? WHERE id = ?");
			$query->execute([1, $_SESSION['id']]);
			$headers = 'FROM: dpaunovi@local.dev';
			$message = "Bonjour ".$_SESSION['login'].".\nL'Activation des notifications vient d'etre effectué avec succes.";
			mail($_SESSION['mail'], 'Notification', $message, $headers);
			$success['success'] = "Les notifications ont bien été Activées.";
			$_SESSION['notification'] = 1;
		}
		if (isAjax()) {
			header('Content-Type: application/json');
			echo json_encode($success);
			die();
		}
		$_SESSION['success'] = $success;
	}
	redirect();

?>
