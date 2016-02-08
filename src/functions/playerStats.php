<?php
	
function playerStats($id) {

	global $database;

	$matchesPlayed = matchesPlayed($id);

	// played less than 10 games?
	if ($matchesPlayed < 10) {

		return [
		   'levelId' => 0,
		   'level' => 'Newcomer',
		   'rating' => '~'
		];

	}

	// played atleast 10 games
	else {

		$player = $database->get('players',
			[
				'id', 'rating'
			],

			[
				'id' => $id
			]
		);

		$playerPosition = playerPosition($id);

		// if this is you, you're the bandit
		if ($playerPosition == 1) {

			return [
			   'levelId' => 50,
			   'level' => 'Bandit',
			   'rating' => $player['rating']*5
			];

		}

		// not #1? assign a level
		else {

			if ((0 <= $player['rating']) && ($player['rating'] <= 849)) {
			
				return [
				   'levelId' => 1,
				   'level' => 'Junior',
				   'rating' => $player['rating']*5
				];
				
			}

			else if ((850 <= $player['rating']) && ($player['rating'] <= 1099)) {
				
				return [
				   'levelId' => 2,
				   'level' => 'Rookie',
				   'rating' => $player['rating']*5
				];
				
			}

			else if ((1100 <= $player['rating']) && ($player['rating'] <= 1199)) {
				
				return [
				   'levelId' => 3,
				   'level' => 'Scout',
				   'rating' => $player['rating']*5
				];
				
			}
			
			else if ((1100 <= $player['rating']) && ($player['rating'] <= 1199)) {
				
				return [
				   'levelId' => 4,
				   'level' => 'Intermediate',
				   'rating' => $player['rating']*5
				];
				
			}
			
			else if ((1200 <= $player['rating']) && ($player['rating'] <= 1299)) {
				
				return [
				   'levelId' => 5,
				   'level' => 'Fighter',
				   'rating' => $player['rating']*5
				];
				
			}

			else if ((1300 <= $player['rating']) && ($player['rating'] <= 1399)) {
				
				return [
				   'levelId' => 6,
				   'level' => 'Knight',
				   'rating' => $player['rating']*5
				];
				
			}

			else if ((1400 <= $player['rating']) && ($player['rating'] <= 1499)) {
				
				return [
				   'levelId' => 7,
				   'level' => 'Assassin',
				   'rating' => $player['rating']*5
				];
				
			}

			else if ((1500 <= $player['rating']) && ($player['rating'] <= 1599)) {
				
				return [
				   'levelId' => 8,
				   'level' => 'Ninja',
				   'rating' => $player['rating']*5
				];
				
			}

			else if ((1600 <= $player['rating']) && ($player['rating'] <= 1699)) {
				
				return [
				   'levelId' => 9,
				   'level' => 'Warrior',
				   'rating' => $player['rating']*5
				];
				
			}

			else if ((1700 <= $player['rating']) && ($player['rating'] <= 1799)) {
				
				return [
				   'levelId' => 10,
				   'level' => 'Mega',
				   'rating' => $player['rating']*5
				];
				
			}

			else if ((1800 <= $player['rating']) && ($player['rating'] <= 1899)) {
				
				return [
				   'levelId' => 11,
				   'level' => 'Monster',
				   'rating' => $player['rating']*5
				];
				
			}

			else if ((1900 <= $player['rating']) && ($player['rating'] <= 1999)) {
				
				return [
				   'levelId' => 12,
				   'level' => 'Legendary',
				   'rating' => $player['rating']*5
				];
				
			}

			else if ((2000 <= $player['rating']) && ($player['rating'] <= 2099)) {
				
				return [
				   'levelId' => 13,
				   'level' => 'Lord',
				   'rating' => $player['rating']*5
				];
				
			}

			else if ((2100 <= $player['rating'])) {
				
				return [
				   'levelId' => 14,
				   'level' => 'God',
				   'rating' => $player['rating']*5
				];
				
			}

		}

	}
	
}
	
?>