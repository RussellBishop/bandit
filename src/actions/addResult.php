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
				'id', 'name', 'rating', 'email'
			],
		
			[
				'id' => $winner
			]
		
		);
		
	$loserData = 
		
		$database->get("players",
		
			[
				'id', 'rating', 'email'
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
	$to      = 'nobody@example.com';
	$subject = 'New result sent by '.$winnerData['name'];
	$message = 'hello';
	$headers = 'From: noreply@russellbishop.co.uk' . "\r\n" .
	    'Reply-To: noreply@russellbishop.co.uk' . "\r\n" .
	    'X-Mailer: PHP/' . phpversion();

	mail($to, $subject, $message, $headers);
	*/


	/*
		When the match is ACCEPTED by the opponent, RE-CALCULATE THE NEW RATINGS due to possible multiple pending matches.
	*/

	header('Location: /match.php?match='.$newResult);
	
	
	
?>