<?php
	
	require_once($_SERVER['DOCUMENT_ROOT'].'/src/config.php');
	require_once($src.'libs/elo/rating.php');
	require_once($functions.'functions.php');

	$datetime = $_POST['datetime'];

	// winner id (you)
	$winnerId = $you['id'];

	// loser id (opponent)
	$loserId = $_POST['opponent'];

	// how many wins?
	$winCount = $_POST['winCount'];

	if ($winCount == 0) {

		echo 'We cant add 0 wins.';
		die;

	}

	elseif ($winCount > 20) {

		echo 'Too many games at once.';
		die;

	}


	// get players' last ratings
	$winnerRatingToCalculate = playersRatingToCalculate($winnerId);
	$loserRatingToCalculate = playersRatingToCalculate($loserId);


	// calculate the difference
	$rating = new Rating($winnerRatingToCalculate, $loserRatingToCalculate, 1, 0);
			
		$results = $rating->getNewRatings();
		
		$winnerNewRating = round($results['a']);
		
		$difference = $winnerNewRating - $winnerRatingToCalculate;




	



	// for every win against this player...
	for ($i = 0; $i < $winCount; $i++) {


		// get their live rating
		$winnerData =

			$database->get("players",
			
				[
					'rating'
				],
			
				[
					'id' => $winnerId
				]
			
			);
			
		$loserData = 
			$database->get("players",
			
				[
					'rating'
				],
			
				[
					'id' => $loserId
				]
			
			);

		$winnerNewLiveRating = $winnerData['rating'] + $difference;
		$loserNewLiveRating = $loserData['rating'] - $difference;



		// Add the match
		$newResult = $database->insert('matches',[

			'datetime'					=> date("Y-m-d 00:00:00"),
			'sent-datetime'				=> date("Y-m-d H:i:s",strtotime('+'.$i.' seconds')),
			'sent-by'					=> $you['id'],

			'winner'					=> $winnerId,
			'loser'						=> $loserId,

			'winner-original-rating'	=> $winnerData['rating'],
			'loser-original-rating'		=> $loserData['rating'],

			'difference'				=> $difference,
			
			'winner-new-rating'			=> $winnerNewLiveRating,
			'loser-new-rating'			=> $loserNewLiveRating,

			'accepted'					=> '1',

		]);



		// Update Winner Rating
		$database->update('players',
		
			[
				'rating[+]' => $difference
			],
			
			[
				'id' => $winnerId
			]
			
		);
		
		
		// Update Loser Rating
		$database->update('players',
		
			[
				'rating[-]' => $difference
			],
			
			[
				'id' => $loserId
			]
			
		);

		$to      = 'hey@russellbishop.co.uk';
		$subject = 'New result sent by '.$you['id'];
		$message = 'New Bandit Match: <a href="'.$_SERVER['DOCUMENT_ROOT'].'/match.php?match='.$newResult.'"></a>';
		$headers = 'From: noreply@russellbishop.co.uk' . "\r\n" .
		    'Reply-To: noreply@russellbishop.co.uk' . "\r\n" .
		    'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);

	}

	// All done? Go to matches.php
	header('Location: /matches.php');
	
?>