<?php

	session_start();
	include '../../config/init.php';

	function auth($log, $pwd){
		if ($log && $pwd)
		{
			if (($db = connect_db())) {
				$sql = "SELECT `login`, `password` from `Users`";
				$query = $db -> query($sql);
				foreach ($query as $row) {
					if ($row['login'] == $log) {
						if ($row['password'] == hash("whirlpool", $pwd)) {
							return (1);
						}
						else {
							return (-1);
						}
					}
				}
				return (0);
			}
		}
		return (-2);
	}
?>
