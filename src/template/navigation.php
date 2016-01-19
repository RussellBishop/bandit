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

<h1><?=$you['name']?></h1>

<nav>	
	<a href="/">Dashboard</a>
	<a href="/notifications.php">Notifications<?php if ($notifications>0) { echo '('.$notifications.')'; } ?></a>
	<a href="/results.php">Results</a>
	<a href="/leaderboard.php">Leaderboard</a>
	<a href="/account.php">Account</a>
	<a href="/logout.php">Logout</a>
</nav>
