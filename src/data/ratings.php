<?php

	$ratings = $database->select('players',
	
		[
			'rating'
		],
		
		[
			"ORDER" => ['rating ASC']
		]
		
	);
	
?>