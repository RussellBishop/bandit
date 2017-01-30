<?php
	
	require_once($_SERVER['DOCUMENT_ROOT'].'/src/config.php');
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

	'You&rsquo;re in&hellip; sick!

	Your password is set to '.$playerPassword.' right now - I know, not your choice, but you can update it the moment you log in.

	Log in and update your password, then start adding your wins, building your rating, and levelling up.

	Your Bandit Club: <a href="'.$_SERVER['REQUEST_URI'].'/"></a>';

	$headers = 'From: noreply@russellbishop.co.uk' . "\r\n" .
	    'Reply-To: noreply@russellbishop.co.uk' . "\r\n" .
	    'X-Mailer: PHP/' . phpversion();

	mail($to, $subject, $message, $headers);

	// All done? Go to their profile
	header('Location: /player.php?player='.$newPlayer);

	}
	
?>