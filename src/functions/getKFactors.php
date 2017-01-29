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
			Get winner's K factor
		*/

		if ($winnerGamesBeforeToday < $minimumGames) { // winner is newcomer
			$winnerKFactor = 32;
		}
			else { // winner is rated
				if ($loserGamesBeforeToday < $minimumGames) { // loser is newcomer
					$winnerKFactor = 12;
				}
				else { // both rated
					$winnerKFactor = 24;
				}
			}


		/*
			Get loser's K factor
		*/

		if ($loserGamesBeforeToday < $minimumGames) { // loser is newcomer
			$loserKFactor = 32;
		}

		else { // loser is rated
			if ($winnerGamesBeforeToday < $minimumGames) { // loser is newcomer
				$loserKFactor = 12;
			}
			else { // both rated
				$loserKFactor = 24;
			}
		}

		/*
			Spit it out!
		*/

		return [
		   'winnerKFactor' => $winnerKFactor,
		   'loserKFactor' => $loserKFactor
		];

	}

?>