<?php
	
	function show_level($id) {

		global $database;

		$player = $database->get('players',
			[
				'id', 'rating'
			],

			[
				'id' => $id
			]
		);

		$highestRating = $database->max('players', 'rating');

		if ($highestRating == $player['rating']) {

			return [
			   'id' => 7,
			   'level' => 'Bandit'
			];

		}

		else {

			if ((0 <= $player['rating']) && ($player['rating'] <= 849)) {
			
				return [
				   'id' => 1,
				   'level' => 'Joker'
				];
				
			}

			else if ((850 <= $player['rating']) && ($player['rating'] <= 1199)) {
				
				return [
				   'id' => 2,
				   'level' => 'Rookie'
				];
				
			}
			
			else if ((1200 <= $player['rating']) && ($player['rating'] <= 1399)) {
				
				return [
				   'id' => 3,
				   'level' => 'Intermediate'
				];
				
			}
			
			else if ((1400 <= $player['rating']) && ($player['rating'] <= 1699)) {
				
				return [
				   'id' => 4,
				   'level' => 'Slayer'
				];
				
			}
			
			else if ((1700 <= $player['rating'])) {
				
				return [
				   'id' => 3,
				   'level' => 'Destroyer'
				];
				
			}

		}

		
	}
	
?>