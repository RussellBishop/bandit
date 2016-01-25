<?php
	
	session_start();
	
	if (isset($_POST['player']) and isset($_POST['password'])) {
		
		// Did they just submit the form?
		$player = $_POST['player'];
		$plainTextPassword = $_POST['password'];

		$player = $database->get('players',
		
			[
				'id', 'password'
			],
			
			[
				'id' => $player
			]
			
		);

		if (password_verify($plainTextPassword, $player['password'])) { 

		    $_SESSION['player'] = $player;

		} else { 

		    echo 'Invalid password.'; 

		} 		
		
	}

	if (isset($_SESSION['player'])) {
		
		// We're logged in
		require_once($data.'you.php');
		
	} else {

		require_once($data.'players.php');
		
		// Guest
		require($template.'header.php');
		require($template.'login.php');

		require($template.'footer.php');
		require($template.'endHtml.php');

		die();
	}
	
?>