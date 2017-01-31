<?php
	
	require_once($_SERVER['DOCUMENT_ROOT'].'/src/config.php');
	require_once($src.'libs/elo/rating.php');
	require_once($functions.'functions.php');
	
	
	$matchId = $_POST['match-id'];

	
	// Get the match info
	$matchData = $database->get('matches',
		[
			'[><]players (sent-by)' => ['sent-by' => 'id'],
			'[><]players (winner)' => ['winner' => 'id'],
			'[><]players (loser)' => ['loser' => 'id']
		],
		
		[
			'matches.id',
			'matches.datetime',
			'matches.sent-by',
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


	$dateSentPeriod = new DateTime($matchData['sent-datetime']);
	$allottedTime = $dateSentPeriod->modify("+24 hours");

	
	if (date("Y-m-d H:i:s") < $allottedTime) {


	    // Update Winner Rating
		$database->update('players',
		
			[
				'rating[-]' => $matchData['winner-difference']
			],
			
			[
				'id' => $matchData['winner']
			]
			
		);
		
		
		// Update Loser Rating
		$database->update('players',
		
			[
				'rating[+]' => $matchData['loser-difference']
			],
			
			[
				'id' => $matchData['loser']
			]
			
		);
	    
	    // Update Match to Declined and add message
		$database->update('matches',
		
			[
				'accepted' => '0',
				'declined' => '1',
				'winner-new-rating' => $matchData['winner-original-rating'],
				'loser-new-rating' => $matchData['loser-original-rating']
			],
			
			[
				'id' => $matchId
			]
			
		);
	    
		
		header('Location: /matches.php');

	}

	else {
		"Too late to dispute this match!";
	}
	
?>