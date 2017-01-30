<?php

	function isWaiting($id) {

		global $database;

		/*

		If you’ve played no games in the last 30 days, or less than 10 in total.

		*/

		$playersGames = countPlayersGames($id);

		if ($playersGames < 10) {
			return 'yes';
		}

		else if () {
			// Find this player in a game between today and 30 days ago

			// Unwritten
		}

	}

?>