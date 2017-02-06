<?php

	function countGames() {

		global $database;

		$countGames = $database->count('matches');

		return $countGames;

	}

?>