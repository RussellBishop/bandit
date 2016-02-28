<?php

	$view = 'profile';

	require_once('src/config.php');

	require_once($data.'players.php');
	require_once($data.'ratings.php');	
	
	require_once($functions.'functions.php');
	
	require($template.'header.php');
	require($template.'navigation.php');

?>

<?php

	echo '<a href="/add-win.php" class="block button is--good">Add Wins</a>';

?>

<?php
	
	$playerId = $you['id'];

	require($template.'playerProfile.php');

?>

<?php

	require($template.'footer.php');

?>

<?php

	require($template.'endHtml.php');
	
?>