<?php

	require_once('src/config.php');

	require_once($data.'players.php');
	require_once($data.'ratings.php');
	
	require_once($src.'auth/authenticate.php');
	
	require_once($functions.'functions.php');
	
	require($template.'header.php');
	require($template.'navigation.php');
	
?>

<?php
	
	$playerId = $_GET['player'];
	require($template.'playerProfile.php');

?>

<?php

	require($template.'footer.php');

?>

<?php

	require($template.'endHtml.php');
	
?>