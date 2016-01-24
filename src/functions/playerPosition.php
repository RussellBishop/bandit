<?php

function playerPosition($playerRating) {
	
global $database;

	$ratings = $database->select('players',
		[
			'rating'
		],

		[
			'ORDER' => ['rating DESC']
		]
	);

	$i = 0;

	foreach ($ratings as $rating) {

		$i++;

		if ($rating['rating'] == $playerRating) {
			echo $i;
			break;
		}

	}

}

?>