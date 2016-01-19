<?php

	function showRating($you) {
		
		global $database;
		
		$matchesPlayed = $database->count('matches',
			[
				'AND' => [
					'OR' => [
						'winner' => $you['id'],
						'loser' => $you['id']
					],
					'accepted' => '1',
				],
			]
		);
		
		if ($matchesPlayed < 10) {
			
			echo '~';
			
		}
		
		else {
			
			$playerRating = $database->get('players',
			
				[
					'rating'
				],
				
				[
					'id' => $you['id']
				]
				
			);
			
			echo $playerRating['rating'];
			
		}
						
	}
	
?>