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

	if ($winCount < 1) {

		echo 'You can&rsquo;t add 0 wins.';
		die;

	}

	elseif ($winCount > 20) {

		echo 'Too many games at once.';
		die;

	}

	$playerIds = [
		'winnerId' => $winnerId,
		'loserId' => $loserId
	];

	$getKFactors = getKFactors($playerIds);

	// get players' last ratings
	$winnerRatingToCalculate = playersRatingToCalculate($winnerId);
	$loserRatingToCalculate = playersRatingToCalculate($loserId);


	// calculate winner's new rating
	$calculateWinner = new Rating($winnerRatingToCalculate, $loserRatingToCalculate, 1, 0, $getKFactors['winnerKFactor']);
			
		$winnerResults = $calculateWinner->getNewRatings();
		
		$winnerNewRating = round($winnerResults['a']);
		
		$winnerDifference = $winnerNewRating - $winnerRatingToCalculate;


	// calculate loser's new rating
	$calculateLoser = new Rating($winnerRatingToCalculate, $loserRatingToCalculate, 1, 0, $getKFactors['loserKFactor']);
			
		$loserResults = $calculateLoser->getNewRatings();
		
		$loserNewRating = round($loserResults['b']);
		
		$loserDifference = $loserRatingToCalculate - $loserNewRating;
		

	// for every win against this player...
	for ($i = 0; $i < $winCount; $i++) {


		// get their live rating
		$winnerData =

			$database->get("players",
			
				[
					'rating', 'name'
				],
			
				[
					'id' => $winnerId
				]
			
			);
			
		$loserData = 
			$database->get("players",
			
				[
					'rating', 'email', 'name'
				],
			
				[
					'id' => $loserId
				]
			
			);

		$winnerNewLiveRating = $winnerData['rating'] + $winnerDifference;

		$loserNewLiveRating = $loserData['rating'] - $loserDifference;



		// Add the match
		$newResult = $database->insert('matches',[

			'datetime'					=> date("Y-m-d 00:00:00"),
			'sent-datetime'				=> date("Y-m-d H:i:s",strtotime('+'.$i.' seconds')),
			'sent-by'					=> $you['id'],

			'winner'					=> $winnerId,
			'loser'						=> $loserId,

			'winner-original-rating'	=> $winnerData['rating'],
			'winner-new-rating'			=> $winnerNewLiveRating,

			'loser-original-rating'		=> $loserData['rating'],			
			'loser-new-rating'			=> $loserNewLiveRating,

			'winner-difference'			=> $winnerDifference,
			'loser-difference'			=> $loserDifference,

			'accepted'					=> '1'

		]);



		// Update Winner Rating
		$database->update('players',
		
			[
				'rating[+]' => $winnerDifference
			],
			
			[
				'id' => $winnerId
			]
			
		);
		
		
		// Update Loser Rating
		$database->update('players',
		
			[
				'rating[-]' => $loserDifference
			],
			
			[
				'id' => $loserId
			]
			
		);

	}

	// All done? Go to matches.php
	header('Location: /matches.php');
	
?>