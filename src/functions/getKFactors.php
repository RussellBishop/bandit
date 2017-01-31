<?php

	function getKFactors($playerIds) {

		global $database;

		/*

			If you’ve played less than 30 games, you have a 32 k factor, regardless of opponent.

			If you’ve played more than 30 games, and so has your opponent, both your k factors are 24.

			If you’ve played more than 30 games and your opponent hasn’t, your K factor is 12

		*/

		$winnerGamesBeforeToday = countPlayersGamesBeforeToday($playerIds['winnerId']);
		$loserGamesBeforeToday = countPlayersGamesBeforeToday($playerIds['loserId']);

		$minimumGames = 30;

		/* 
			Calculate K factors
		*/
		if ($winnerGamesBeforeToday < $minimumGames) {
			// winner is newcomer
			$winnerKFactor = 32;

			if ($loserGamesBeforeToday < $minimumGames) {
				// both newcomers
				$loserKFactor = 32;
			}

			else {
				// winner is new
				// loser is old
				$loserKFactor = 12;
			}
		}

		else {
			
			if ($loserGamesBeforeToday < $minimumGames) {
				// winner is old
				// loser is newcomer
				$winnerKFactor = 12;
				$loserKFactor = 32;
			}

			else {
				// both rated
				$winnerKFactor = 24;
				$loserKFactor = 24;
			}
		}


		return [
		   'winnerKFactor' => $winnerKFactor,
		   'loserKFactor' => $loserKFactor
		];

	}

?>