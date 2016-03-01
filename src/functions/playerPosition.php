<?php

function playerPosition($id) {
	
	global $database;

	$players = $database->select('players',

		[
			'id', 'rating'
		],
		
		[
			"ORDER" => ['rating DESC']
		]
		
	);

	$leaderboardPlayers = []; 

	foreach ($players as $player) {

		$matchesPlayed = countPlayersGames($player['id']);

		if ($matchesPlayed > 9 ) {

			$leaderboardPlayers[] = $player['id'];

		}
	}

	array_unshift($leaderboardPlayers, "unshift");
	unset($leaderboardPlayers[0]);

	$playersPosition = array_search($id, $leaderboardPlayers);

	return $playersPosition;

}

?>