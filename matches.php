<?php

	$view = 'matches';
	require_once('src/config.php');

	require_once($data.'players.php');
	require_once($data.'ratings.php');

	require_once($functions.'functions.php');
	
	require($template.'header.php');
	require($template.'navigation.php');
	
?>

<?php
		
	$pendingResults = $database->select('matches',
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
					'winner' => $you['id'],
					'loser' => $you['id']
				],
				'sent-by[!]' => $you['id'],
				'accepted' => '0',
				'declined' => '0'
			]
		]
	);

	if (!empty($pendingResults)) {

		echo '
		<section class="block results">
		<h1 class="h1">Pending</h1>';
		
		foreach ($pendingResults as $pendingResult) {
			
			echo '
				
				<li>
					<a href="/match.php?match='.$pendingResult['id'].'" class="g2 slate is--result is--pending">
						
						<div class="base"></div>
						
							<div class="col1 player is--a">
								';
								
								playerPhoto($pendingResult['winner-id']);
								
								echo '
								<div class="difference">Win</div>
							</div>
							
							<div class="col2 player is--b">
								';
								
								playerPhoto($pendingResult['loser-id']);
								
								echo '
								<div class="difference">Loss</div>
							</div>
							
						<p class="meta is--bottom is--pending">Pending</p>
						
					</a>
				</li>
				
			';
			
		}

		echo '</section>';

	}
	
?>

<section class="block results">

<h1 class="h1">Matches</h1>

<ul>

	<?php
		
		$matches = $database->select('matches',
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
				'accepted' => '1',
				"ORDER" => "matches.datetime DESC",
				"LIMIT" => 20
			]
		);
		
		foreach ($matches as $match) {
			
			echo '
				<li>
					<a href="/match.php?match='.$match['id'].'" class="g2 slate is--result">
					
						<div class="base"></div>
						
							<div class="col1 player is--a is--winner">
							
								<figure class="position-triangle">'
								.file_get_contents('src/img/position-triangle.svg').
								'</figure>';
								
								playerPhoto($match['winner-id']);
								
								echo '
								<div class="difference">+'. $match['difference']*5 .'</div>
							</div>
							
							<div class="col2 player is--b is--loser">
							
								<figure class="position-triangle">'
								.file_get_contents('src/img/position-triangle.svg').
								'</figure>';
								
								playerPhoto($match['loser-id']);
								
								echo '
								<div class="difference">-'. $match['difference']*5 .'</div>
							</div>
						
						<p class="meta is--bottom is--when">'. timeSince(strtotime($match['datetime'])) .' ago</p>
						
					</a>
				</li>';
			
		}
		
	?>
	
</ul>
	
</section>

<?php

	require($template.'footer.php');

?>

<?php

	require($template.'endHtml.php');
	
?>