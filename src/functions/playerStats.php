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
				   'level' => 'Joker',
				   'rating' => $player['rating']*5
				];
				
			}

			else if ((850 <= $player['rating']) && ($player['rating'] <= 1199)) {
				
				return [
				   'levelId' => 2,
				   'level' => 'Rookie',
				   'rating' => $player['rating']*5
				];
				
			}
			
			else if ((1200 <= $player['rating']) && ($player['rating'] <= 1399)) {
				
				return [
				   'levelId' => 3,
				   'level' => 'Intermediate',
				   'rating' => $player['rating']*5
				];
				
			}
			
			else if ((1400 <= $player['rating']) && ($player['rating'] <= 1699)) {
				
				return [
				   'levelId' => 4,
				   'level' => 'Slayer',
				   'rating' => $player['rating']*5
				];
				
			}
			
			else if ((1700 <= $player['rating'])) {
				
				return [
				   'levelId' => 3,
				   'level' => 'Destroyer',
				   'rating' => $player['rating']*5
				];
				
			}

		}

	}
	
}
	
?>