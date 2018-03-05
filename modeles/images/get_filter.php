<?php

	function get_filter() {
		$dir = "./images/filter";
		$files = scandir($dir);
		$filter = glob($dir.'/*.{jpeg,gif,png}', GLOB_BRACE);
		foreach ($filter as $row) {
			echo "<button onClick='selectFilter(this)'><img src='$row' alt='' /></button>";
		}
	}

?>
