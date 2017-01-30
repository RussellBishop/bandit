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
			'sent-datetime',
			'winner',
			'loser',
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

		
	    $disputeMessage = $_POST['dispute-message'];

	    $database->update('matches',
		
			[
				'dispute-message' => $disputeMessage,
				'declined' => '1',
			],
			
			[
				'id' => $matchId
			]
			
		);

	    $to      = 'hey@russellbishop.co.uk';
		$subject = 'Dispute sent by '.$you['id'];
		$message = 'Match was disputed: <a href="'.$_SERVER['DOCUMENT_ROOT'].'/match.php?match='.$matchData['id'].'"></a>';
		$headers = 'From: noreply@russellbishop.co.uk' . "\r\n" .
		    'Reply-To: noreply@russellbishop.co.uk' . "\r\n" .
		    'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);	    
		
		header('Location: /matches.php?prompt=disputed');

	}

	else {
		"Too late to dispute this match!";
	}
	
?>