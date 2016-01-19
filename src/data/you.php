<?php
	
	if (isset($_SESSION['player'])) {
	
		$you = $database->get('players',
		
			[
				'id', 'name', 'email', 'photo', 'rating'
			],
			
			[
				'id' => $_SESSION['player']
			]
			
		);
		
	}
	
	else {
		
	}
		
?>