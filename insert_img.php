<?php
	include('./Database/db.php');
	session_start();
	
	$login = $_SESSION['logged_on_user'];
	if ($login) {
		$img = $_GET['img'];

		if ($db = connect_db()) {
			$sql = "
					INSERT INTO `Pictures` (`path_img`, `login`) VALUES
					('$img', '$login');";
			$db->query($sql);
		}
//		header("location: home.php");
	}
//	header("location: index.php");
?>
