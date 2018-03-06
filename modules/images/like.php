<?php

	session_start();
	require '../../config/init.php';
	if (!$_SESSION['id']) {
		$errors['logged'] = "vous devez etre connecté.";
		if (isAjax()) {
//			header('Content-Type: application/json', true, 400);
			header('Content-Type: application/json');
			echo json_encode($errors);
			die();
		}
		$_SESSION['errors'] = $errors;
		redirect();
	}
	else {
		require '../../modeles/images/like.php';
	}

?>
