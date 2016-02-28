<?php
	
	function playersRatingToCalculate($id) {

		global $database;

		$countPlayersGames = countPlayersGames($id);

		// new player
		if ($countPlayersGames < 1) {

			$playersLiveRating =

					$database->get("players", 'rating',
					
						[
							'id' => $id
						]
					
					);

			return $playersLiveRating;

		}

		// player has some games
		else {

			$lastGameBeforeToday = selectLastGameBeforeToday($id);

			// games must be from today
			if (empty($lastGameBeforeToday)) {
				
				$selectFirstGameToday = selectFirstGameToday($id);

				// was the winner
				if ($selectFirstGameToday['winner'] == $id) {

					return $selectFirstGameToday['winner-original-rating'];

				}

				// was the loser
				elseif ($selectFirstGameToday['loser'] == $id) {
					
					return $selectFirstGameToday['loser-original-rating'];

				}

			}

			// has a game from the past
			else {

				// was the winner
				if ($lastGameBeforeToday['winner'] == $id) {

					return $lastGameBeforeToday['winner-original-rating'];

				}

				// was the loser
				elseif ($lastGameBeforeToday['loser'] == $id) {
					
					return $lastGameBeforeToday['loser-original-rating'];

				}

			}
		}
	}

?>