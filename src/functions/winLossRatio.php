<?php
	
	function winLossRatio($id) {
		
		global $database;
	
		$wins = $database->count('matches',
			[
				'datetime',
			],
			
			[
				'AND' => [
					'winner' => $id,
					'accepted' => '1',
					'declined' => '0',
				]
			]
		);
		
		$losses = $database->count('matches',
			[
				'datetime',
			],
			
			[
				'AND' => [
					'loser' => $id,
					'accepted' => '1',
					'declined' => '0',
				]
			]
		);
		
		if ($losses > 0) {
			return (float)number_format(($wins/$losses), 2, '.', '');
		}
		
		else {
			return $wins;
		}
		
	}
					
?>