<?php

	$players = $database->select('players',
	
		[
			'id', 'name', 'rating'
		],
		
		[
			"ORDER" => ['name ASC']
		]
		
	);
	
?>