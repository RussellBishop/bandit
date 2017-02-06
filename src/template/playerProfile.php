<?php

	$player = $database->get('players',
		
		[
			'id', 'name', 'email', 'photo', 'rating'
		],
		
		[
			'id' => $playerId
		]
		
	);

	$playerStats = playerStats($player['id']);

	$matchesPlayed = countPlayersGames($player['id']);

	if ($matchesPlayed > 9) {
		$playerLevel == '0';
	}
	else {
		$playerLevel == $playerStats['levelId'];
	}

?>

<figure class="block player-card is--level<?=$playerLevel?>">

	<header class="player-identity">

		<h1 class="player-name h1"><?=$player['name']?></h1>

		<?php if ($player['id'] == $you['id']) { ?>

			<a href="/account.php" class="go-to-account">

			<?php playerPhoto($player['id']); ?>

			<div class="player-level"><?=$playerLevel?></div>

			</a>

		<?php } else { ?>

			<div class="go-to-account">

			<?php playerPhoto($player['id']); ?>

			<div class="player-level"><?=$playerLevel?></div>
					
			</div>

		<?php } ?>
	
	</header>
	
	<?php

		if ($matchesPlayed > 9) {
			include($template.'playerStats.php');
		}

	?>
    
</figure>

<?php

	if ($matchesPlayed > 9) {
		include($template.'playerStatsExtra.php');
	}



		else {

			$countPlayersGames = countPlayersGames($player['id']);

			$gamesRemaining = 10 - $countPlayersGames;

			echo '<h3 class="h3 block is--textcentre prompt is--inline is--prompted">Waiting&hellip; '.$gamesRemaining.' games left to play!</h1>';

		}

?>

<?php
	
	$mostRecentResults = $database->select('matches',
		[
			'[><]players (winner)' => ['winner' => 'id'],
			'[><]players (loser)' => ['loser' => 'id'],
		],
		
		[
			'matches.id',
			'matches.datetime',
			'matches.sent-by',
			'winner.id(winner-id)',
			'loser.id(loser-id)',
			'winner.name(winner-name)',
			'loser.name(loser-name)',
			'matches.winner',
			'matches.loser',
			'matches.accepted',
			'matches.declined',

			'matches.winner-original-rating',
			'matches.winner-new-rating',
			'matches.winner-difference',

			'matches.loser-original-rating',
			'matches.loser-new-rating',
			'matches.loser-difference',
		],
		
		[
			'AND' => [
				'OR' => [
					'winner' => $player['id'],
					'loser' => $player['id']
				],
			],
			
			'ORDER' => "matches.sent-datetime DESC",
			"LIMIT" => 5
		]
	);

	if (!empty($mostRecentResults)) {

		echo '<section class="block results"><ul>';
		
		foreach ($mostRecentResults as $match) {
			
			$winnerStats =  playerStats($match['winner-id']);
			$loserStats =  playerStats($match['loser-id']);

			if ($match['declined'] == 1) {
				$isDisputed = ' is--disputed';
			}

			else {
				$isDisputed = '';
			}
			
			echo '<li>';

			include($template.'matchSlab.php');

			echo '</li>';
		
		}

		echo '</ul></section>';
	}

?>

</ul>

</section>