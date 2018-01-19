<?php

	if (!$_SESSION['logged_on_user'])
		header("location: ./");
	require("./modeles/settings/user_settings.php");

	$submit = $_POST['submit'];
	if ($submit == 'changepw') {
		echo "plop";
	}
	else if ($submit == 'changemail') {
		echo "plop";
	}
	else if ($submit == 'delete') {
		echo "plop";
	}

	$profil = user_params();

	require './view/settings.php';

?>
