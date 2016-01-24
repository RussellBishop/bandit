<?php
	
	session_start();
	
	if (isset($_POST['player']) and isset($_POST['password'])) {
		
		// Did they just submit the form?
		$player = $_POST['player'];
		$password = $_POST['password'];
		
		$exists = $database->has('players', [
			"AND" => [
				'id' => $player,
				'password' => $password,
			]
		]);
		
		if ($exists == 1) {
			
			$_SESSION['player'] = $player;
			
		}
		
		else {
			
			echo "Invalid Login Credentials.";
			
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