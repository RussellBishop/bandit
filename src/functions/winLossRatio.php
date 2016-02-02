<?php
	
	function winLossRatio($youId) {
		
		global $database;
	
		$wins = $database->count('matches',
			[
				'datetime',
			],
			
			[
				'AND' => [
					'winner' => $youId,
					'accepted' => '1',
				]
			]
		);
		
		$losses = $database->count('matches',
			[
				'datetime',
			],
			
			[
				'AND' => [
					'loser' => $youId,
					'accepted' => '1',
				]
			]
		);
		
		if ($losses > 0) {
			return (float)number_format(($wins/$losses), 2, '.', '');
		}
		
		else {
			return '0';
		}
		
	}
					
?>