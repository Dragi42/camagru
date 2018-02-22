<?php

	//	Retrieve token

	if (isset($_GET["token"]) && preg_match('/^[0-9A-F]{40}$/i', $_GET["token"])) {
		$token = $_GET["token"];
	}
	else {
		throw new Exception("Valid token not provided.");
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
			throw new Exception("Valid token not provided.");
		}
	
		//  delete token so it can't be used again
	
		if ($_SERVER["REQUEST_TIME"] - $tstamp > $delta) {
			throw new Exception("Token has expired.");
			$query = $db->prepare("DELETE FROM `Users` WHERE login = ? AND token = ? AND tstamp = ?");
			$query->execute([$login, $token, $tstamp]);
		}
		else {


!!!!			$query = $db->prepare("UPDATE `login`, `tstamp` FROM `Users` WHERE token = ?");
!!!!			$query->execute([$token]);


		}

	// do one-time action here, like activating a user account

		var_dump($row);

		die();
	}
	header('location: ../../');

?>
