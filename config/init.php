<?php

// Connexion a la base de donnée
	function connect_db() {
		$DB_DSN = 'mysql:host=127.0.0.1;dbname=db_camagru';
		$DB_USER = 'root';
		$DB_PASSWORD = '';
		$db = new PDO($DB_DSN, $DB_USER, $DB_PASWORD);

		return ($db);
	}

	function isAjax() {
		return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}

	function redirect() {
		header("location: ".$_SERVER['HTTP_REFERER']."");
	}

?>
