<?php

	if (!$_SESSION['id']) {
		$errors['logged'] = "vous devez etre connecté.";
		if (isAjax()) {
			header('Content-Type: application/json', true, 400);
			echo json_encode($errors);
			die();
		}
		$_SESSION['errors'] = $errors;
		header("location: ./");
	}
	else {
		require './modeles/images/like.php';
	}

?>
