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

	$prompt = $_GET['prompt'];

	if ($prompt == 'notfound') {
		echo '<aside class="prompt is--prompted is--warning is--inline block">We couldn&rsquo;t find that match! It may have been cancelled.</aside>';
	}

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
						
					</a>
				</li>
				
			';
			
		}

		echo '</section>';

	}
	
?>








<?php




// DateTime Object ( [date] => 2016-02-02 22:22:53.000000 [timezone_type] => 3 [timezone] => Europe/London )
$lastMatchDayMorningDateTime = DateTime::createFromFormat('Y-m-d H:i:s', date("Y-m-d", strtotime($database->max("matches", "datetime"))) . '00:00:00');

// 2016-02-02
$lastMatchDay = $lastMatchDayMorningDateTime->format('Y-m-d');

// create empty array
$matchDays = array();

// run 7 times
for ($i=0; $i < 7; $i++) {

	// clone the original date
	$newDateTime = clone $lastMatchDayMorningDateTime;

	// minus $i days
	$newDateTime->modify('-'.$i.' day');

	// add date to array
	$matchDays[] = $newDateTime;

}

foreach ($matchDays as $matchDay) {

	$endOfMatchDay = clone $matchDay;
	$endOfMatchDay->modify('+1 day');


	// Select the matches
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
			"AND" => [
				'accepted' => '1',
				'matches.datetime[<>]' => [$matchDay->format("Y-m-d H:i:s"), $endOfMatchDay->format("Y-m-d H:i:s")]
			],
			'ORDER' => "matches.datetime DESC",
			
		]
	);

	if (!empty($matches)) {

		echo '
		<section class="block results">
		<h1 class="h1">'.$matchDay->format('l jS').'</h1>';

		foreach ($matches as $match) {

			$winnerLevelId =  playerStats($match['winner-id']);
			$loserLevelId =  playerStats($match['loser-id']);
			
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
							<div class="difference">+<span class="count">'. $match['difference']*5 .'</span></div>
						</div>
						
						<div class="col2 player is--b is--loser">
						
							<figure class="position-triangle">'
							.file_get_contents('src/img/position-triangle.svg').
							'</figure>';
							
							playerPhoto($match['loser-id']);
							
							echo '
							<div class="difference">-<span class="count">'. $match['difference']*5 .'</span></div>
						</div>			

					</a>
				</li>';
			
		}

		echo '</section>';

	}

}

?>
















<?php

/*

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

			$winnerLevelId =  playerStats($match['winner-id']);
			$loserLevelId =  playerStats($match['loser-id']);
			
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
								<div class="difference">+<span class="count">'. $match['difference']*5 .'</span></div>
							</div>
							
							<div class="col2 player is--b is--loser">
							
								<figure class="position-triangle">'
								.file_get_contents('src/img/position-triangle.svg').
								'</figure>';
								
								playerPhoto($match['loser-id']);
								
								echo '
								<div class="difference">-<span class="count">'. $match['difference']*5 .'</span></div>
							</div>
						
						<p class="meta is--bottom is--when">'. timeSince(strtotime($match['datetime'])) .' ago</p>
						
					</a>
				</li>';
			
		}
		
	?>
	
</ul>
	
</section>

*/ ?>

<?php

	require($template.'footer.php');

?>

<?php

	require($template.'endHtml.php');
	
?>