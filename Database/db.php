<?php
function connect_db()
{
	$DB_DSN = 'mysql:host=127.0.0.1;dbname=db_camagru';
	$DB_USER = 'root';
	$DB_PASSWORD = '';
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASWORD);
	return ($db);
}
?>
