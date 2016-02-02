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

					$bestLoserStats = playerStats($bestWin[0]['loser-id']);

					echo '<a href="/match.php?match=' .$bestWin[0]['id']. '">';
					echo 'Versus. ';
					playerPhotoInline($bestWin[0]['loser-id']);
					echo ' ' .$bestWin[0]['loser-name']. ' ('.$bestLoserStats['rating'].')</a>';
					
				?>
			</p>
		</li>

	<?php } ?>
	
</ol>