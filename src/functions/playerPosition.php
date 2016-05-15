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

	$oneMonthAgo = date("Y-m-d 00:00:00", strtotime('-1 month'));

	$leaderboardPlayers = []; 





	foreach ($players as $player) {

		$lastGame = selectLastGame($player['id']);

		$matchesPlayed = countPlayersGames($player['id']);

		if ($matchesPlayed > 9 ) {

			if ($lastGame['datetime'] > $oneMonthAgo) {

				$leaderboardPlayers[] = $player['id'];

			}

		}
	}

	array_unshift($leaderboardPlayers, "unshift");
	unset($leaderboardPlayers[0]);

	$playersPosition = array_search($id, $leaderboardPlayers);

	return $playersPosition;

}

?>