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

?>

<figure class="block player-card is--level<?=$playerStats['levelId']?>">

	<header class="player-identity">

		<h1 class="player-name h1"><?=$player['name']?></h1>

		<?php if ($player['id'] == $you['id']) { ?>

			<a href="/account.php" class="go-to-account">

			<?php playerPhoto($player['id']); ?>

			<div class="player-level"><?=$playerStats['level']?></div>

			</a>

		<?php } else { ?>

			<div class="go-to-account">

			<?php playerPhoto($player['id']); ?>

			<div class="player-level"><?=$playerStats['level']?></div>
					
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

			echo '<h3 class="h3 block is--textcentre prompt is--inline is--prompted">'.$gamesRemaining.' games left to play!</h1>';

		}



?>

<section class="block results">
    
	<ul>
    
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
				'matches.loser-original-rating',
				'matches.difference',
				'matches.winner-new-rating',
				'matches.loser-new-rating'
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
		
		foreach ($mostRecentResults as $result) {
			
			$winnerStats =  playerStats($result['winner-id']);
			$loserStats =  playerStats($result['loser-id']);

			if ($result['declined'] == 1) {
				$isDisputed = ' is--disputed';
			}

			else {
				$isDisputed = '';
			}
			
			echo '
				<li>
					<a href="/match.php?match='.$result['id'].'" class="g2 slate is--result'.$isDisputed.'">
					
						<div class="base"></div>
						
						<div class="col1 player is--a is--winner is--level'.$winnerStats['levelId'].'">
						
							<figure class="position-triangle">'
							.file_get_contents('src/img/position-triangle.svg').
							'</figure>';
							
							playerPhoto($result['winner-id']);
							
							echo '
							<div class="difference">+<span class="count">'. $result['difference']*5 .'</span></div>
						</div>
						
						<div class="col2 player is--b is--loser is--level'.$loserStats['levelId'].'">
						
							<figure class="position-triangle">'
							.file_get_contents('src/img/position-triangle.svg').
							'</figure>';
							
							playerPhoto($result['loser-id']);
							
							echo '
							<div class="difference">-<span class="count">'. $result['difference']*5 .'</span></div>
						</div>			

					</a>
				</li>';
		
		}
		
?>

</section>