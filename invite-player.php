<?php

	if ($you['role'] !== 'admin') {
		http_response_code(404);
		die;
	}

	$view = 'invite-player';

	require_once('src/config.php');

	require_once($data.'players.php');
	require_once($data.'ratings.php');
		
	require_once($functions.'functions.php');
	
	require($template.'header.php');
	require($template.'navigation.php');
	
?>

<h1 class="h1">You&rsquo;re inviting&hellip;</h1>

<form class="block table is--result" method="post" action="<?=$actions.'invitePlayer.php';?>">

	<ol class="block table">

		<li class="row">

			<label for="fullname">Full Name:</label>
			<input type="text" name="fullname" id="fullname" />

		</li>

		<li class="row">

			<label for="email">Email Address:</label>
			<input type="text" name="email" id="email" />

		</li>

		<li>
			<button type="submit" class="button is--good" name="submit">Invite Player</button>
		</li>

	</ol>

</form>

<?php

	require($template.'footer.php');

?>

<?php

	require($template.'endHtml.php');
	
?>