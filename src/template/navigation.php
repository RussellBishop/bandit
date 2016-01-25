<?php
	
	$notifications = $database->count('matches',
			
		[
			'AND' => [
				'OR' => [
					'winner' => $you['id'],
					'loser' => $you['id']
				],
				'sent-by[!]' => $you['id'],
				'accepted' => '0',
				'declined' => '0',
			]
		]
		
	);
		
?>

<nav class="menu">

	<label for="menu">Menu</label>

	<input class="toggle" name="menu" id="menu" type="checkbox" />

	<div class="fullscreen toggled">

		<label for="menu" class="close">X</label>


		<ul>
			<li><a href="/">My Profile</a></li>
			<li><a href="/add-result.php">Add Result</a></li>
			<li><a href="/matches.php">Matches <?php if ($notifications>0) { echo '('.$notifications.')'; } ?></a></li>
			<li><a href="/leaderboard.php">Leaderboard</a></li>
			<li><a href="/account.php">Account</a></li>
		</ul>
	</div>
</nav>