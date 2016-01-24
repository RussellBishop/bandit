<?php

	$view = 'leaderboard';
	
	require_once('src/config.php');
	
	require_once($data.'players.php');
	
	require_once($functions.'functions.php');
	
	require($template.'header.php');
	require($template.'navigation.php');
	
?>

<article class="block leaderboard">

	<h1 class="h1">Leaderboard</h1>
	
	<ol>
	
	<?php
	
	$leaderboardPlayers = $database->select('players',
	
		[
			'id', 'name', 'photo', 'rating'
		],
		
		[
			"ORDER" => ['rating DESC']
		]
		
	);
	
	foreach ($leaderboardPlayers as $player) {

		$playerStats = playerStats($player['id']);

		$matchesPlayed = matchesPlayed($player['id']);

		print_r($matchesPlayed);

		if ($matchesPlayed > 0) {

			$lastGame = $database->select('matches',
				[
					'datetime', 'winner', 'loser'
				],
				
				[
					'AND' => [
						'OR' => [
							'winner' => $player['id'],
							'loser' => $player['id']
						],
						'accepted' => '1',
					],
					
					"ORDER" => "datetime DESC",
					"LIMIT" => 1
				]
			);

			if ($lastGame[0]['winner'] == $player['id']) {
				$lastGameResult = 'is--winner';
			}
			elseif ($lastGame[0]['loser'] == $player['id']) {
				$lastGameResult = 'is--loser';
			}

			if ($player['id'] == $you['id']) {
				$isYou = 'is--you';
			}
			else {
				$isYou = '';
			}
			
			echo '<li><a href="player.php?player=' .$player['id']. '" class="g3 slate is--position ' .$lastGameResult. ' is--level' . $playerStats['levelId']. ' ' .$isYou. '">
			
				<div class="base"></div>
				
				<div class="col1">';
				
				playerPhoto($player['id']);
				
				echo '
				</div>
				
				<header class="col2 player-info">
					<h1>' .$player['name']. '</h1>
					<h2 class="player-level">' .$playerStats['level']. '</h2>
				</header>
				
				<aside class="col3 player-rating">
					<h3>' .$playerStats['rating']. '</h3>

					<figure class="position-triangle">'
					.file_get_contents('src/img/position-triangle.svg').
					'</figure>
				</aside>
				
				';
			
			echo '</div></li>';

		}
		
	}
	
	?>
	
	</ol>
		
</article>

<?php

	require($template.'footer.php');

?>

<?php

	require($template.'endHtml.php');
	
?>