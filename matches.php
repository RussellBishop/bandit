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
	$endOfMatchDay->modify('+1 day -1 second');


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
			'ORDER' => "matches.sent-datetime DESC",
			
		]
	);

	if (!empty($matches)) {

		echo '
		<section class="block results">
		<h1 class="h1">'.$matchDay->format('l jS').'</h1>';

		foreach ($matches as $match) {

			$winnerStats =  playerStats($match['winner-id']);
			$loserStats =  playerStats($match['loser-id']);

			if ($match['declined'] == 1) {
				$isDisputed = ' is--disputed';
			}

			else {
				$isDisputed = '';
			}
			
			echo '
				<li>
					<a href="/match.php?match='.$match['id'].'" class="g2 slate is--result'.$isDisputed.'">
					
						<div class="base"></div>
						
						<div class="col1 player is--a is--winner is--level'.$winnerStats['levelId'].'">
						
							<figure class="position-triangle">'
							.file_get_contents('src/img/position-triangle.svg').
							'</figure>';
							
							playerPhoto($match['winner-id']);
							
							echo '
							<div class="difference">+<span class="count">'. $match['difference']*5 .'</span></div>
						</div>
						
						<div class="col2 player is--b is--loser is--level'.$loserStats['levelId'].'">
						
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

	require($template.'footer.php');

?>

<?php

	require($template.'endHtml.php');
	
?>