<?php
	
	require_once($_SERVER['DOCUMENT_ROOT'].'/src/config.php');
	
	require_once($src.'libs/elo/rating.php');
	

	$datetime = $_POST['datetime'];
	$opponent = $_POST['opponent'];
	$outcome = $_POST['outcome'];

	
	if ($outcome == 'won') {
		
		$winner = $you['id'];
		$loser = $opponent;
		
	}
	
	else {
		
		$loser = $you['id'];
		$winner = $opponent;

	}
	
	$winnerData = 
			
		$database->get("players",
		
			[
				'id', 'rating'
			],
		
			[
				'id' => $winner
			]
		
		);
		
	$loserData = 
		
		$database->get("players",
		
			[
				'id', 'rating'
			],
		
			[
				'id' => $loser
			]
		
		);
	
	$rating = new Rating($winnerData['rating'], $loserData['rating'], 1, 0);
		
		$results = $rating->getNewRatings();
		
		$winnerNewRating = round($results['a']);
		$loserNewRating = round($results['b']);
		
		$difference = $winnerNewRating - $winnerData['rating'];
	
	
	$newResult = $database->insert('matches',[
		'datetime'					=> $datetime,
		'sent-datetime'				=> date("Y-m-d H:i:s"),
		'sent-by'					=> $you['id'],
		'winner'					=> $winner,
		'loser'						=> $loser,
		'winner-original-rating'	=> $winnerData['rating'],
		'loser-original-rating'		=> $loserData['rating'],
		'difference'				=> $difference,
		'winner-new-rating'			=> $winnerNewRating,
		'loser-new-rating'			=> $loserNewRating,
	]);

	/*
		When the match is ACCEPTED by the opponent, RE-CALCULATE THE NEW RATINGS due to possible multiple pending matches.
	*/

	header('Location: /index.php');
	
	
	
?>