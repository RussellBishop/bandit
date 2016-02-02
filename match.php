<?php

	require_once('src/config.php');

	require_once($data.'players.php');
	require_once($data.'ratings.php');
	
	require_once($functions.'functions.php');
	
	require($template.'header.php');
	require($template.'navigation.php');
	
?>

<?php

	$matchId = $_GET['match'];

	if (empty($matchId)) {
		header('Location: /matches.php');
	}

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

	if ($match[0]['accepted'] == 0 && $match[0]['declined'] == 0) {

		$matchStatus = 'pending';

	}

	elseif ($match[0]['accepted'] == 1 && $match[0]['declined'] == 0) {
		
		$matchStatus = 'accepted';

	}

	elseif ($match[0]['declined'] == 1 && $match[0]['accepted'] == 0) {

		$matchStatus = 'declined';

	}

?>

<article class="match is--<?=$matchStatus?>">

	<?php
	if ($matchStatus == 'pending') {
		echo '<h1 class="h1">Match pending&hellip;</h1>';
	}

	elseif ($matchStatus == 'declined') {
		echo '<h1 class="h1">Match declined</h1>';
	}
	?>


	<section class="score g4">

		<?php

			$winnerStats = playerStats($match[0]['winner-id']);
			$loserStats = playerStats($match[0]['loser-id']);

		?>

		<div class="player is--winner is--level<?=$winnerStats['rating']?>">

			<a href="player.php?player=<?=$match[0]['winner-id']?>">
				<?php playerPhoto($match[0]['winner-id']); ?>
				<h1 class="name"><?=$match[0]['winner-name']?></h1>
			</a>
			<h2 class="rating"><?=$winnerStats['rating']?></h2>

			<div class="result">Win</div>
		</div>

		<div class="player is--loser">

			<a href="player.php?player=<?=$match[0]['loser-id']?>">
				<?php playerPhoto($match[0]['loser-id']); ?>
				<h1 class="name"><?=$match[0]['loser-name']?></h1>
			</a>

			<h2 class="rating"><?=$loserStats['rating']?></h2>

			<div class="result">Loss</div>
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
		<p><?php playerPhotoInline($match[0]['sent-by']); ?> <?=$match[0]['sent-by-name']?></p>

	</li>

	<li class="row">
		<h3 class="h4">Game Played:</h4>
		<p>
		<?php

			echo timeSince(strtotime($match[0]['datetime'])) . ' ago';

		?> 
		</p>
		<p>
		<?php

			$matchDatetime = DateTime::createFromFormat('Y-m-d H:i:s', $match[0]['datetime']);
			$matchWorded = $matchDatetime->format('l g:iA, F dS Y');

			echo $matchWorded;

		?>
		</p>
	</li>

	<?php

		if ($matchStatus == 'declined') {

			?>

			<li class="row is--disputed">
			<h3 class="h4">Disputed:</h4>
			<p class="quote">
				<?=$match[0]['dispute-message'];?>
			</p>
		</li>

			<?

		}

	?>

	</ol>

	<?php

		if ($matchStatus == 'pending') {

			if ($match[0]['sent-by'] != $you['id']) {
				// Not sent by me;

				if ($match[0]['winner-id'] == $you['id'] || $match[0]['loser-id'] == $you['id']) {
					// But I was in the game (I'm the opponent)

					?>

					<form class="actions" method="post" action="<?=$actions.'answerPendingResult.php'?>">
						
						<input type="hidden" name="match-id" value="<?=$match[0]['id']?>" />
						
						<button type="submit" class="button" name="accepted">Accept result</button>
						
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

		}

	?>

	


</article>

<?php

	require($template.'footer.php');

?>

<?php

	require($template.'endHtml.php');
	
?>