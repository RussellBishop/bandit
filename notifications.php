<?php
	
	require_once('src/config.php');
	
	require_once($src.'libs/medoo/medoo.php');
	
	require_once($data.'database.php');
	require_once($data.'players.php');
	
	require_once($src.'auth/authenticate.php');
	
	require($template.'header.php');
	require($template.'navigation.php');
	
?>

<h1>Pending Confirmation</h1>

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
					'declined' => '0',
				]
			]
		);
		
		foreach ($pendingResults as $pendingResult) {
			
			echo '
			
				<form method="post" action="/src/actions/answerPendingResult.php">
					
					<input type="hidden" name="match-id" value="' . $pendingResult['id'] . '" />
				
					<ul>
						<li>Winner: ' . $pendingResult['winner-name'] . ' (' . $pendingResult['winner-original-rating'] . ')</li>
						<li>Loser: ' . $pendingResult['loser-name'] . ' (' . $pendingResult['loser-original-rating'] . ')</li>
					</ul>
					
					<button type="submit" name="accepted">Accept</button>
					
					<label for="dispute">Dispute</label>
					<input type="checkbox" id="dispute" />
					
					<div class="explain-dispute">
						<textarea name="dispute-message"></textarea>
						<button type="submit" name="disputed">Send Dispute</button>
					</div>
					
				</form>
			
			';
			
			echo '<br />';
			
		}
		
	?>