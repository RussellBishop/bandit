<?php
	
	require_once($_SERVER['DOCUMENT_ROOT'].'/src/config.php');
	require_once($src.'libs/elo/rating.php');
	require_once($functions.'functions.php');	
	
	
	$matchId = $_POST['match-id'];
	
	// Get the match info
	$database->delete('matches', [
			'id' => $matchId
		]
	);
	
	header('Location: /matches.php?prompt=deleted');
	
?>