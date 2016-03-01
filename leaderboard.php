<?php

	$view = 'leaderboard';
	
	require_once('src/config.php');
	
	require_once($functions.'functions.php');
	
	require($template.'header.php');
	require($template.'navigation.php');


	$leaderboardPlayers = $database->select('players',
	
		[
			'id', 'name', 'photo', 'rating'
		],
		
		[
			"ORDER" => ['rating DESC']
		]
		
	);
	
?>

<article class="block leaderboard">

	<h1 class="h1">Leaderboard</h1>
	
	<ol>
	
	<?php
	
	foreach ($leaderboardPlayers as $player) {

		$matchesPlayed = countPlayersGames($player['id']);

		// they've played 10 matches
		if ($matchesPlayed > 9) {

			$playerStats = playerStats($player['id']);

			$lastGame = selectLastGame($player['id']);

			if ($lastGame['winner'] == $player['id']) {
				$lastGameResult = 'is--winner';
			}
			elseif ($lastGame['loser'] == $player['id']) {
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
			
			echo '</a></li>';

		}
		
	}
	
	?>
	
	</ol>

</article>

<article class="block leaderboard">

	<h1 class="h1">Waiting&hellip;</h1>

	<ol>
	
	<?php
		
	foreach ($leaderboardPlayers as $player) {

		$matchesPlayed = countPlayersGames($player['id']);

		// haven't played 10 matches
		if ($matchesPlayed < 10) {

			$playerStats = playerStats($player['id']);

			$lastGame = selectLastGame($player['id']);

			if ($lastGame['winner'] == $player['id']) {
				$lastGameResult = 'is--winner';
			}
			elseif ($lastGame['loser'] == $player['id']) {
				$lastGameResult = 'is--loser';
			}

			if ($player['id'] == $you['id']) {
				$isYou = 'is--you';
			}
			else {
				$isYou = '';
			}
			
			echo '<li><a href="player.php?player=' .$player['id']. '" class="g3 slate is--pending is--position ' .$lastGameResult. ' is--level' . $playerStats['levelId']. ' ' .$isYou. '">
			
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
				</aside>
				
				';
			
			echo '</a></li>';

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