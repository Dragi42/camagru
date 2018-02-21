<?php
	$DB_DSN = 'mysql:host=127.0.0.1';
	$DB_USER = 'root';
	$DB_PASSWORD = '';

	try {
		$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		echo "Connected successfully"; 
	}
	catch(PDOException $e) {
		echo "Connection failed: " . $e->getMessage();
	}
	$createdb = 'CREATE DATABASE IF NOT EXISTS db_camagru CHARACTER SET `utf8`;';
	$db -> query($createdb);
	$db -> query('USE db_camagru;');
	
	$sql ="
		CREATE TABLE IF NOT EXISTS Users (
			`id` int(11) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT,
			`login` VARCHAR(32) NOT NULL,
			`password` VARCHAR(128) NOT NULL,
			`mail` VARCHAR(64) NOT NULL,
			`token` VARCHAR(64) DEFAULT NULL
		) ENGINE=InnoDB;";
	$db -> query($sql);

	$sql ="
		CREATE TABLE IF NOT EXISTS Pictures (
			`id` int(11) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT,
			`path_img` LONGBLOB NOT NULL,
			`user_id` int(11) unsigned NOT NULL,
			`comment` int(11) unsigned DEFAULT '0',
			`like` int(11) unsigned DEFAULT '0'
		) ENGINE=InnoDB;";
	$db -> query($sql);

	$sql ="
		CREATE TABLE IF NOT EXISTS Likes (
			`id` int(11) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT,
			`user_id` int(11) unsigned NOT NULL,
			`picture_id` int(11) unsigned NOT NULL
		) ENGINE=InnoDB;";
	$db -> query($sql);

	$sql ="
		CREATE TABLE IF NOT EXISTS Comments (
			`id` int(11) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT,
			`user_id` int(11) unsigned NOT NULL,
			`picture_id` int(11) unsigned NOT NULL,
			`date` DATETIME DEFAULT 'CURRENT_TIMESTAMP',
			`content` TEXT DEFAULT NOT NULL
		) ENGINE=InnoDB;";
	$db -> query($sql);

#	$sql ="#
#		INSERT INTO `Pictures` (`path_img`, `login`, `describe`, `tags`, `comment`, `like`) VALUES
#		";
#	$db -> query($sql);

	$sql ="
		INSERT INTO `Users` (`login`, `password`, `mail`) VALUES
			('dpaunovi', '".hash('whirlpool', 'root')."', 'dpaunovi@student.42.fr');";
	$db -> query($sql);
#	$req = $db -> query('SELECT * FROM');

?>
