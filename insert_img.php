<?php
	include('Database/db.php');
	session_start();
	$login = $_SESSION['logged_on_user'];
	if ($login) {
		$img = $_POST['img'];
		echo $img;
		echo $_POST['plop'];
		echo "plop";
	}
	else {
		header('location: index.php');
	}
?>
