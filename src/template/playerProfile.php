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
	
	<ul class="g1 player-stats">
		
		<li>
			<dt>Rating</dt>
			<dd><?=$playerStats['rating']?></dd>
		</li>
		
		<li>
			<dt>Position</dt>
			<dd><a href="leaderboard.php">#<?php playerPosition($player['rating']); ?></a></dd>
		</li>
		
		<li>
			<dt>Win Ratio</dt>
			<dd><?php winLossRatio($player['id']);?></dd>
		</li>

    </ul>
    
</figure>

<?php if ($player['id'] == $you['id']) { ?>

<a href="/add-result.php" class="block button">Add Result</a>

<?php } ?>

<ol class="block table">
	
	<li class="row">
		<h3 class="h4">Games played:</h4>
		<p>
			<?php
				
		    	$gamesPlayed = $database->count('matches',
					[
						'id',
					],
					
					[
						'AND' => [
							'OR' => [
								'winner' => $player['id'],
								'loser' => $player['id']
							],
							'accepted' => '1',
						],
					]
				);
				
				$gamesWon = $database->count('matches',
					[
						'id',
					],
					
					[
						'AND' => [
							'winner' => $player['id'],
							'accepted' => '1',
						],
					]
				);
				
				$gamesLost = $database->count('matches',
					[
						'id',
					],
					
					[
						'AND' => [
							'loser' => $player['id'],
							'accepted' => '1',
						],
					]
				);
				
				echo $gamesPlayed .' Total (' .$gamesWon.' won / ' .$gamesLost.' lost)';
				
			?>
		</p>
	</li>

	<?php
				
    	$bestWin = $database->select('matches',
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
				'loser.photo(loser-photo)',
				'matches.winner',
				'matches.loser',
				'matches.accepted',
				'matches.declined',
				'matches.winner-original-rating',
				'matches.loser-original-rating',
			],
			
			[
				'AND' => [
					'OR' => [
						'winner' => $player['id']
					],
					'accepted' => '1',
				],
				
				"ORDER" => "matches.loser-original-rating DESC",
				"LIMIT" => 1
			]
			
		);

		if (!empty($bestWin)) { ?>
	
	<li class="row">
		<h3 class="h4">Best win:</h3>
		<p>
			<?php

				echo '<a href="/result.php?result=' .$bestWin[0]['id']. '">';
				echo 'Versus. ';
				playerPhotoInline($bestWin[0]['loser-id']);
				echo ' ' .$bestWin[0]['loser-name']. ' (' ;
				playerStats($bestWin[0]['loser-id']);
				echo '</a>';
				
			?>
		</p>
	</li>

	<?php } ?>

	<?php
	/*
	
	<li>
		<h3 class="h3">Best streak:</h3>
		<p>X games over Y period</p>
	</li>

	<li>
		<h3 class="h3">Reputation:</h3>
		<p>Perfect</p>
	</li>

	*/
	?>
	
</ol>

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
				
				"ORDER" => "matches.datetime DESC",
				"LIMIT" => 5
			]
		);
		
		foreach ($mostRecentResults as $result) {
			
			if ($result['accepted'] == 0) {
				
				echo '
				
				<li>
					<a href="/match.php?match='.$result['id'].'" class="g2 slate is--result is--pending">
						
						<div class="base"></div>
						
							<div class="col1 player is--a">
								';
								
								playerPhoto($result['winner-id']);
								
								echo '
								<div class="difference">Win</div>
							</div>
							
							<div class="col2 player is--b">
								';
								
								playerPhoto($result['loser-id']);
								
								echo '
								<div class="difference">Loss</div>
							</div>
							
						<p class="meta is--bottom is--pending">Pending</p>
						
					</a>
				</li>
				
				';
				
			}
			
			else {
				
				echo '
				<li>
					<a href="/match.php?match='.$result['id'].'" class="g2 slate is--result">
					
						<div class="base"></div>
						
							<div class="col1 player is--a is--winner">
							
								<figure class="position-triangle">'
								.file_get_contents('src/img/position-triangle.svg').
								'</figure>';
								
								playerPhoto($result['winner-id']);
								
								echo '
								<div class="difference">+'. $result['difference']*5 .'</div>
							</div>
							
							<div class="col2 player is--b is--loser">
							
								<figure class="position-triangle">'
								.file_get_contents('src/img/position-triangle.svg').
								'</figure>';
								
								playerPhoto($result['loser-id']);
								
								echo '
								<div class="difference">-'. $result['difference']*5 .'</div>
							</div>
						
						<p class="meta is--bottom is--when">'. timeSince(strtotime($result['datetime'])) .' ago</p>
						
					</a>
				</li>';
				
			}
		
		}
		
?>

</section>