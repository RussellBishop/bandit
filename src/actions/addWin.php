<?php
	
	require_once($_SERVER['DOCUMENT_ROOT'].'/src/config.php');
	require_once($src.'libs/elo/rating.php');
	require_once($functions.'functions.php');
	

	$datetime = $_POST['datetime'];


	// winner id (you)
	$winnerId = $you['id'];

	// loser id (opponent)
	$loserId = $_POST['opponent'];



	$winnerData = 
		$database->get("players",
		
			[
				'id', 'name', 'rating', 'email'
			],
		
			[
				'id' => $winnerId
			]
		
		);
		
	$loserData = 
		$database->get("players",
		
			[
				'id', 'rating', 'rating', 'email'
			],
		
			[
				'id' => $loserId
			]
		
		);



	/*
		LOSERS RATING ($losersRating)
	*/

	// get games before today
	$losersPreviousGamesCount = gamesBeforeToday($loserId);

	// if no games before today,  get rating from the players table
	if ($losersPreviousGamesCount == '0') {

		$losersRating = $loserData['rating'];

	}

	// if they have previous games, get the last game and find their id
	else {

		$losersLastGame = selectLastGameBeforeToday($loserId);

		if ($losersLastGame['winner'] == $loserId) {

			$losersRating = $losersLastGame['winner-original-rating'];

		} elseif ($losersLastGame['loser'] == $loserId) {
			
			$losersRating = $losersLastGame['loser-original-rating'];

		}

	}





	/*
		WINNERS RATING ($winnersRating)
	*/

	// get games before today
	$winnersPreviousGamesCount = gamesBeforeToday($winnerId);

	// if no games before today,  get rating from the players table
	if ($winnersPreviousGamesCount == '0') {

		$winnersRating = $winnerData['rating'];

	}

	// if they have previous games, get the last game and find their id
	else {

		$winnersLastGame = selectLastGameBeforeToday($winnerId);

		if ($winnersLastGame['winner'] == $winnerId) {

			$winnersRating = $winnersLastGame['winner-original-rating'];

		} elseif ($winnersLastGame['loser'] == $winnerId) {
			
			$winnersRating = $winnersLastGame['loser-original-rating'];

		}

	}


	
	
	
	$rating = new Rating($winnersRating, $losersRating, 1, 0);
		
		$results = $rating->getNewRatings();
		
		$winnerNewRating = round($results['a']);
		$loserNewRating = round($results['b']);
		
		$difference = $winnerNewRating - $winnerData['rating'];
	
	
	$newResult = $database->insert('matches',[
		'datetime'					=> $datetime,
		'sent-datetime'				=> date("Y-m-d H:i:s"),
		'sent-by'					=> $you['id'],

		'winner'					=> $winnerId,
		'loser'						=> $loserId,

		'winner-original-rating'	=> $winnersRating,
		'loser-original-rating'		=> $losersRating,

		'difference'				=> $difference,
		
		'winner-new-rating'			=> $winnerNewRating,
		'loser-new-rating'			=> $loserNewRating
	]);

	if ($newResult == '0') {

		$thenewresult = array (
		'datetime'					=> $datetime,
		'sent-datetime'				=> date("Y-m-d H:i:s"),
		'sent-by'					=> $you['id'],

		'winner'					=> $winnerId,
		'loser'						=> $loserId,

		'winner-original-rating'	=> $winnersRating,
		'loser-original-rating'		=> $losersRating,

		'difference'				=> $difference,
		
		'winner-new-rating'			=> $winnerNewRating,
		'loser-new-rating'			=> $loserNewRating
		);

		print_r($thenewresult);

	} 

	else {

		header('Location: /match.php?match='.$newResult);

	}


	/*
	$to      = 'hey@russellbishop.co.uk';
	$subject = 'New result sent by '.$winnerData['name'];
	$message = 'New Bandit Match: <a href="http://bandit.localhost/match.php?match='.$newResult.'"></a>';
	$headers = 'From: noreply@russellbishop.co.uk' . "\r\n" .
	    'Reply-To: noreply@russellbishop.co.uk' . "\r\n" .
	    'X-Mailer: PHP/' . phpversion();

	mail($to, $subject, $message, $headers);
	*/
	
?>