<?php

	require './database.php';

	try {
		$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		echo "Connected successfully</br></br>"; 
	}
	catch(PDOException $e) {
		echo "Connection failed: " . $e->getMessage();
	}
	$status = $db->query("SHOW DATABASES like 'db_camagru'");
if (!$status->fetch()) {
	$createdb = 'CREATE DATABASE IF NOT EXISTS db_camagru CHARACTER SET `utf8`;';
	$db->query($createdb);
	$db->query('USE db_camagru;');
	
	$sql ="
		CREATE TABLE IF NOT EXISTS Users (
			`id` int(11) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT,
			`login` VARCHAR(16) NOT NULL,
			`password` VARCHAR(128) NOT NULL,
			`mail` VARCHAR(64) NOT NULL,
			`notification` TINYINT(1) DEFAULT '1',
			`tstamp` INTEGER UNSIGNED NOT NULL,
			`token` VARCHAR(40) NOT NULL
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
			`date` DATETIME DEFAULT CURRENT_TIMESTAMP,
			`content` TEXT NOT NULL
		) ENGINE=InnoDB;";
	$db -> query($sql);

	$sql ="
		INSERT INTO `Users` (`login`, `password`, `mail`, tstamp, token) VALUES
			('dpaunovi', '".hash('whirlpool', 'root')."', 'dpaunovi@student.42.fr', '1', '1');";
	$db -> query($sql);

	$sql ="
		INSERT INTO `Pictures` (`path_img`, `user_id`) VALUES
			('https://scontent-cdg2-1.xx.fbcdn.net/v/t1.0-9/22222048_10214409176007463_2477477119281503536_n.jpg?oh=cc1815e65da52d2c98a491f313c8defd&oe=5B0373DA', '1');
		INSERT INTO `Pictures` (`path_img`, `user_id`) VALUES
			('https://scontent-cdg2-1.xx.fbcdn.net/v/t31.0-8/27797457_10215551268474445_9145563302530623255_o.jpg?oh=2e8344c403a536c77577c5db2e3c2e3a&oe=5B499BC8', '1');
		INSERT INTO `Pictures` (`path_img`, `user_id`) VALUES
			('https://scontent-cdg2-1.xx.fbcdn.net/v/t1.0-9/27067595_1478829492229420_6747751786388341850_n.jpg?oh=195404fbac13c4a144ec5a62185ad910&oe=5B3A4A9E', '1');
		INSERT INTO `Pictures` (`path_img`, `user_id`) VALUES
			('https://scontent-cdg2-1.xx.fbcdn.net/v/t31.0-8/15000011_1054033524709021_5872171586983305486_o.jpg?oh=35d35b9ef5d0e96122e9defae14b9aef&oe=5B492B03', '1');
		INSERT INTO `Pictures` (`path_img`, `user_id`) VALUES
			('https://scontent-cdg2-1.xx.fbcdn.net/v/t1.0-9/21752112_1351148538330850_675443866508554138_n.jpg?oh=a7783f201c378b3d273cb74547539145&oe=5B0BCB2D', '1');
		INSERT INTO `Pictures` (`path_img`, `user_id`) VALUES
			('https://scontent-cdg2-1.xx.fbcdn.net/v/t1.0-9/21231860_1341380902640947_5086004970850278355_n.jpg?oh=acb3f4869b9a72065b62a9d0eb0f9258&oe=5B48DBF4', '1');
		";
	$db -> query($sql);
}
else {
		echo "Database already exist."; 
}

?>
