<?php

	function showRating($id) {
		
		global $database;

		$matchesPlayed = matchesPlayed($id);
		
		if ($matchesPlayed < 10) {
			
			echo '~';
			
		}
		
		else {
			
			$playerRating = $database->get('players',
			
				[
					'rating'
				],
				
				[
					'id' => $id
				]
				
			);
			
			echo $playerRating['rating'];
			
		}
						
	}
	
?>