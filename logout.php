<?php
	
	session_start();
	
	if (isset($_SESSION['player'])) {
		
		session_destroy();
		header('Location: index.php');
		
	} else {
		
		// Guest
		require('src/template/header.php');
		
		header('Location: login.php');

	}
	
?>