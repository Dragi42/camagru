<?php

	$login = $_POST[login];
	$passwd = $_POST[passwd];
	$cpasswd = $_POST[cpasswd];
	$mail = $_POST[mail];
	$file = "../private/passwd";

	if (!$login || !$passwd || !$cpasswd || !$mail || $_POST[submit] != "OK")
		echo "Error: All of the form is not complete\n";
	else if ($passwd != $cpasswd)
		echo "Error: Password incorrect\n";
	else {
		if (!file_exists("../private"))
			mkdir("../private");
		if (!file_exists($file))
			$current = file_put_contents($file, NULL);
		$current = unserialize(file_get_contents($file));
		if ($current) {
			foreach ($current as $user => $val) {
				if ($val['login'] == $login) {
					$exist = 1;
					echo "Error: Login already used\n";
				}
			}
		}
		if (!$exist) {
			$passwd = hash('whirlpool', $_POST[passwd]);
			$current[] = array('login' => $login,
				'passwd' => $passwd, 'mail' => $mail);
			file_put_contents($file, serialize($current));
		}
	}

?>
