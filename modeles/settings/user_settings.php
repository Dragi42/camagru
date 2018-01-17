<?php

	function user_params() {
		$db = connect_db();
		$login = $_SESSION['logged_on_user'];
		$profil = $db->query("SELECT `login`, `passwd`, `mail` FROM `Users` where login='$login'");
		return ($profil);
	}

?>
