<?php

	require_once('src/config.php');

	// Let's look closer at this match...

	$matchId = $_GET['match'];

	if (empty($matchId)) {

		header('Location: /matches.php');
		die();

	}

	else {

		$matchExists = $database->has("matches",
			[
			'id' => $matchId
			]
		);

		if ($matchExists == 0) {
			header('Location: /matches.php?prompt=notfound');
			die();
		}

	}

?>

<?php

	require_once($data.'players.php');
	require_once($data.'ratings.php');
	
	require_once($functions.'functions.php');
	
	require($template.'header.php');
	require($template.'navigation.php');
	
?>

<?php

	
	$match = $database->get('matches',
		[
			'[><]players (sent-by)' => ['sent-by' => 'id'],
			'[><]players (winner)' => ['winner' => 'id'],
			'[><]players (loser)' => ['loser' => 'id']
		],
		
		[
			'matches.id',
			'matches.datetime',
			'matches.sent-by',
			'sent-by.name(sent-by-name)',
			'matches.sent-datetime',
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

			'matches.dispute-message',
		],
		
		[
			'matches.id' => $matchId
		]
	);

?>

<?php

	// 1 day after it was sent
	$dateSentPeriod = date('Y-m-d H:i:s', strtotime($match['sent-datetime'] . '+1 day'));

	if ($match['accepted'] == 1 && $match['declined'] == 0) {

		if (date("Y-m-d H:i:s") > $dateSentPeriod) {

			// it's past the period to dispute
			$matchStatus = 'accepted';


		} else {

			// it's still disputable
			$matchStatus = 'disputable';

		}

	}

	elseif ($match['declined'] == 1) {

		$matchStatus = 'declined';

	}

?>

<article class="match is--<?=$matchStatus?>">

	<?php


		if ($matchStatus == 'declined') {
			echo '<h1 class="h1">Match declined</h1>';
		}

	?>


	<section class="score g4">

		<?php

			$winnerStats = playerStats($match['winner-id']);
			$loserStats = playerStats($match['loser-id']);

		?>

		<div class="player is--winner is--level<?=$winnerStats['levelId']?>">

			<a href="player.php?player=<?=$match['winner-id']?>">
				<?php playerPhoto($match['winner-id']); ?>
				<h1 class="name"><?=$match['winner-name']?></h1>
			</a>
			<h2 class="rating"><?=$match['winner-original-rating']*5?></h2>

			<div class="result">+<?=$match['winner-difference']*5?></div>
		</div>

		<div class="player is--loser is--level<?=$loserStats['levelId']?>">

			<a href="player.php?player=<?=$match['loser-id']?>">
				<?php playerPhoto($match['loser-id']); ?>
				<h1 class="name"><?=$match['loser-name']?></h1>
			</a>

			<h2 class="rating"><?=$match['loser-original-rating']*5?></h2>

			<div class="result">-<?=$match['loser-difference']*5?></div>
		</div>

	</section>

	<ol class="block table">

	<li class="row">
		<h3 class="h4">Game Played:</h4>
		<p>
		<?php

			echo timeSince(strtotime($match['datetime'])) . ' ago';

		?> 
		</p>
	</li>

	</ol>

	<form class="actions" method="post" action="<?=$actions.'cancelResult.php'?>">
						
			<input type="hidden" name="match-id" value="<?=$match['id']?>" />
			
			<button type="submit" class="button is--bad" name="delete">Cancel result</button>
									
		</form>

	


</article>

<?php

	require($template.'footer.php');

?>

<?php

	require($template.'endHtml.php');
	
?>