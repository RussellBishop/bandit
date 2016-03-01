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

	
	$match = $database->select('matches',
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
			'matches.loser-original-rating',
			'matches.difference',
			'matches.winner-new-rating',
			'matches.loser-new-rating',
			'matches.dispute-message',
		],
		
		[
			'matches.id' => $matchId
		]
	);

?>

<?php

	// 1 day after it was sent
	$dateSentPeriod = date('Y-m-d H:i:s', strtotime($match[0]['sent-datetime'] . '+1 day'));

	if ($match[0]['accepted'] == 1 && $match[0]['declined'] == 0) {

		if (date("Y-m-d H:i:s") > $dateSentPeriod) {

			// it's past the period to dispute
			$matchStatus = 'accepted';


		} else {

			// it's still disputable
			$matchStatus = 'disputable';

		}

	}

	elseif ($match[0]['declined'] == 1) {

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

			$winnerStats = playerStats($match[0]['winner-id']);
			$loserStats = playerStats($match[0]['loser-id']);

		?>

		<div class="player is--winner is--level<?=$winnerStats['levelId']?>">

			<a href="player.php?player=<?=$match[0]['winner-id']?>">
				<?php playerPhoto($match[0]['winner-id']); ?>
				<h1 class="name"><?=$match[0]['winner-name']?></h1>
			</a>
			<h2 class="rating"><?=$match[0]['winner-original-rating']*5?></h2>

			<div class="result">+<?=$match[0]['difference']*5?></div>
		</div>

		<div class="player is--loser is--level<?=$loserStats['levelId']?>">

			<a href="player.php?player=<?=$match[0]['loser-id']?>">
				<?php playerPhoto($match[0]['loser-id']); ?>
				<h1 class="name"><?=$match[0]['loser-name']?></h1>
			</a>

			<h2 class="rating"><?=$match[0]['loser-original-rating']*5?></h2>

			<div class="result">-<?=$match[0]['difference']*5?></div>
		</div>

	</section>

	<ol class="block table">
	
	<li class="row">
		<h3 class="h4">Sent:</h4>
		<p>
		<?php

			echo timeSince(strtotime($match[0]['sent-datetime'])) . ' ago';

		?> 
		</p>

	</li>

	<li class="row">
		<h3 class="h4">Game Played:</h4>
		<p>
		<?php

			echo timeSince(strtotime($match[0]['datetime'])) . ' ago';

		?> 
		</p>
	</li>

	<?php

		if ($matchStatus == 'declined') {

			?>

			<li class="row is--disputed">

				<h3 class="h4">Disputed by <?=$match[0]['loser-name']?>.</h4>

				<?php if (!empty($match[0]['dispute-message'])) { ?>
					<p class="quote">
						<?=$match[0]['dispute-message'];?>
					</p>
				<?php } ?>

			</li>

			<?

		}

	?>

	</ol>

	<?php

		if ($match[0]['sent-by'] == $you['id'] && $matchStatus == 'declined') {

	?>

		<form class="actions" method="post" action="<?=$actions.'cancelResult.php'?>">
						
			<input type="hidden" name="match-id" value="<?=$match[0]['id']?>" />
			
			<button type="submit" class="button is--bad" name="delete">Cancel result</button>
									
		</form>

	<?php

		}

	?>



	<?php

		if ($matchStatus == 'disputable') {

			if ($match[0]['sent-by'] != $you['id']) {
				// Not sent by me;

				if ($match[0]['winner-id'] == $you['id'] || $match[0]['loser-id'] == $you['id']) {
					// But I was in the game (I'm the opponent)

					?>

					<form class="actions" method="post" action="<?=$actions.'disputeResult.php'?>">
						
						<input type="hidden" name="match-id" value="<?=$match[0]['id']?>" />
						
						<input type="checkbox" id="dispute" class="toggle is--dispute" />
						<label for="dispute" class="button is--bad">Dispute result</label>
						
						<div class="block toggled explain-dispute">
							<textarea name="dispute-message"></textarea>
							<button type="submit" class="is--bad" name="disputed">Send Dispute</button>
						</div>
						
					</form>

					<?

				}
			}

			else {

				// I sent this pending game!

				?>

				<form class="actions" method="post" action="<?=$actions.'cancelResult.php'?>">
						
						<input type="hidden" name="match-id" value="<?=$match[0]['id']?>" />
						
						<button type="submit" class="button is--bad" name="delete">Cancel result</button>
												
					</form>

				<?php

			}

		}

	?>

	


</article>

<?php

	require($template.'footer.php');

?>

<?php

	require($template.'endHtml.php');
	
?>