<?php
	
	require_once($_SERVER['DOCUMENT_ROOT'].'/src/config.php');
	require_once($src.'club.php');
	require_once($functions.'functions.php');

	$playerName = $_POST['fullname'];
	$playerEmail = $_POST['email'];
	$playerPassword = rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9);

	$hashedPassword = password_hash($playerPassword, PASSWORD_DEFAULT);

	if (empty($playerName) OR empty($playerEmail)) {
		// Unfinished form
		header('Location: /invite-player.php?prompt=unfinishedform');
		die;
	}

	if ($database->has('players', [
			"email" => $playerEmail
		])
	)
	{
		// Email address exists
		header('Location: /invite-player.php?prompt=emailexists');
		die;
	}

	else {

	// Add the player
	$newPlayer = $database->insert('players',[

		'name'					=> $playerName,
		'email'					=> $playerEmail,
		'password'				=> $hashedPassword,
		'role'					=> 'player',

	]);

$to      = $playerEmail;
$subject = 'Enter - Bandit Play';
$message =

'<html>
<head>
<title>You&rsquo;re in - sick!</title>
</head>
<body>
<h3>You&rsquo;re in&hellip; sick!</h3>
<p>Your password is set to <b>'.$playerPassword.'</b> right now - I know, not your choice, but you can update it the moment you log in.</p>
<p>Start adding your wins, build your rating, and levelling up.</p>
<p>Your Bandit Club: <a href="'.$club['url'].'">'.$club['name'].'</a> '.$club['url'].'</p>';

// To send HTML mail, the Content-type header must be set
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=iso-8859-1';

// Additional headers
$headers[] = 'To: '.$playerName.' <'.$playerEmail.'>';
$headers[] = 'From: Bandit Play <noreply@banditplay.com>';
$headers[] = 'Reply-To: Bandit Play <noreply@banditplay.com>';

mail($to, $subject, $message, implode("\r\n", $headers));

	// All done? Go to their profile
	header('Location: /player.php?player='.$newPlayer);

	}
	
?>