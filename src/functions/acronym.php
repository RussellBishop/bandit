<?php
	
	function acronym($name) {
	
		$words = preg_split("/\s+/", $name);
		
		foreach ($words as $w) {
			$acronym .= $w[0];
		}
		
		echo $acronym;
	
	}
	
?>