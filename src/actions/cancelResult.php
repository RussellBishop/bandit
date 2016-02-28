<?php
	
	require_once($_SERVER['DOCUMENT_ROOT'].'/src/config.php');
	require_once($src.'libs/elo/rating.php');
	require_once($functions.'functions.php');
	
	
	
	$matchId = $_POST['match-id'];

	
	// Get the match info
	$matchData = $database->get('matches',
	
		[
			'id',
			'sent-datetime',
			'winner',
			'loser',
			'difference',
			'winner-original-rating',
			'loser-original-rating',
			'winner-new-rating',
			'loser-new-rating'
		],
		
		[
			'id' => $matchId
		]
	);


	$dateSentPeriod = new DateTime($matchData['sent-datetime']);
	$dateSentPeriod->modify("+24 hours");

	
	if (date("Y-m-d H:i:s") < $dateSentPeriod) {


	    // Update Winner Rating
		$database->update('players',
		
			[
				'rating[-]' => $matchData['difference']
			],
			
			[
				'id' => $matchData['winner']
			]
			
		);
		
		
		// Update Loser Rating
		$database->update('players',
		
			[
				'rating[+]' => $matchData['difference']
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