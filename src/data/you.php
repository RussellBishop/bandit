<?php
	
	if (isset($_SESSION['player'])) {
	
		$you = $database->get('players',
		
			[
				'id', 'name', 'email', 'photo', 'rating', 'role'
			],
			
			[
				'id' => $_SESSION['player']
			]
			
		);
		
	}
	
	else {
		
	}
		
?>