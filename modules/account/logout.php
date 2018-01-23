<?php

	session_unset($_SESSION);
	$_SESSION = [];
	header('location: /?module=account&action=index');

?>
