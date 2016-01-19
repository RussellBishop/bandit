<?php
	
	require_once($_SERVER['DOCUMENT_ROOT'].'/src/config.php');
	
	require_once($src.'libs/medoo/medoo.php');
	
	require_once($data.'database.php');
	
	require_once($src.'auth/authenticate.php');
	
	require_once($src.'libs/elo/rating.php');
	
	
	
	
	
	$matchId = $_POST['match-id'];
	
	// Get the match info
	$matchData = $database->get('matches',
		
		[
			'id',
			'winner',
			'loser'
		],
		
		[
			'id' => $matchId
		]
	);
	
	

	if (isset($_POST['accepted'])) {
		
		
		// Get Winner data
		$winnerData = $database->get('players',
		
			[
				'id',
				'rating'
			],
			
			[
				'id' => $matchData['winner']
			]
		);
		
		// Get Loser data
		$loserData = $database->get('players',
		
			[
				'id',
				'rating'
			],
			
			[
				'id' => $matchData['loser']
			]
		);
		
		
		// Calculate ELOs
		$rating = new Rating($winnerData['rating'], $loserData['rating'], 1, 0);
		
		$results = $rating->getNewRatings();
		
		$winnerNewRating = round($results['a']);
		$loserNewRating = round($results['b']);
		
		$difference = $winnerNewRating - $winnerData['rating'];
		
		
		
		
		// Update Winner Rating
		$database->update('players',
		
			[
				'rating' => $winnerNewRating
			],
			
			[
				'id' => $winnerData['id']
			]
			
		);
		
		
		// Update Loser Rating
		$database->update('players',
		
			[
				'rating' => $loserNewRating
			],
			
			[
				'id' => $loserData['id']
			]
			
		);
		
		
		// Update Match to Accepted
		$database->update('matches',
		
			[
				'winner-new-rating' => $winnerNewRating,
				'loser-new-rating' => $loserNewRating,
				'difference' => $difference,
				'accepted' => '1'
			],
			
			[
				'id' => $matchId
			]
			
		);
		
    }
    
    elseif (isset($_POST['disputed'])) {
	    
	    $disputeMessage = $_POST['dispute-message'];
	    
	    // Update Match to Declined and add message
		$database->update('matches',
		
			[
				'dispute-message' => $disputeMessage,
				'declined' => '1'
			],
			
			[
				'id' => $matchId
			]
			
		);
	    
    }
	
	header('Location: /notifications.php');
	
?>