<?php
	if (parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY) != 'module=account&action=index')
		$_SESSION['lastpage'] = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY);
	if ($_SESSION['id'])
		header("location: ./");

	require './view/log.php';
	
	unset($_SESSION['inputs']);
	unset($_SESSION['logged']);
	

?>
