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
		
		require_once($_SERVER['DOCUMENT_ROOT'].'/src/data/you.php');
		
	} else {
		
		// Guest
		require($_SERVER['DOCUMENT_ROOT'].'/src/template/header.php');
		require($_SERVER['DOCUMENT_ROOT'].'/src/template/login.php');
	
		die();

	}
	
?>