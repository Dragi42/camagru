<?php
	
session_start();
	include '../../config/init.php';

	$login = $_POST[login];
	$passwd = $_POST[passwd];
	$cpasswd = $_POST[cpasswd];
	$mail = $_POST[mail];

	if (!$login || !$passwd || !$cpasswd || !$mail || $_POST[submit] != "OK") {
		$_SESSION['created'] = -3;
		header('location: ../../.?module=auth&action=form');
	}
	else {
		if ($db = connect_db()) {
			$sql = "SELECT * FROM Users;";
			$query = $db -> query($sql);
			foreach ($query as $row) {
				if ($row['login'] == $login) {
					$exist = 1;
					$_SESSION['created'] = -2;
					header('location: ../../.?module=auth&action=form');
				}
			}
		}
		if ($passwd != $cpasswd) {
			$_SESSION['created'] = -1;
			header('location: ../../.?module=auth&action=form');
		}
		if (!$exist) {
			$passwd = hash('whirlpool', $_POST[passwd]);
			$req ="
				INSERT INTO `Users` (`login`, `password`, `mail`) VALUES
				('$login', '$passwd', '$mail');";
			$db -> query($req);
			$_SESSION['created'] = 1;
			header('location: ../../.?module=auth&action=form');
		}
	}

?>
