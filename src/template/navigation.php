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

	$playerStats = playerStats($you['id']);
		
?>

<nav class="menu">

	<label class="menu__toggle" data-toggles="menu">
		<div class="player-photo-wrap is--level<?=$playerStats['levelId']?>"><?php playerPhoto($you['id']); ?></div>
		<figure class="menu__icon"><?php if ($notifications>0) { echo '<span class="new">'.$notifications.'</span>'; } ?></span><?php echo file_get_contents('src/img/menu.svg'); ?></figure>
	</label>

	<div class="fullscreen is--menu" data-is="menu">

		<label class="close" data-toggles="menu">X</label>

		<ul>
			<li class="<?php if ($view == 'profile') { echo 'is--open'; } ?>"><a href="/">My Profile</a></li>
			<li class="<?php if ($view == 'add-win') { echo 'is--open'; } ?>"><a href="/test-results.php">Test Results</a></li>
			<?php /* <li class="<?php if ($view == 'add-win') { echo 'is--open'; } ?>"><a href="/add-win.php">Add Wins</a></li> */ ?>
			<li class="<?php if ($view == 'matches') { echo 'is--open'; } ?>"><a href="/matches.php">Matches<?php if ($notifications>0) { echo '  ('.$notifications.' new)'; } ?></a></li>
			<li class="<?php if ($view == 'leaderboard') { echo 'is--open'; } ?>"><a href="/leaderboard.php">Leaderboard</a></li>
			<li class="<?php if ($view == 'account') { echo 'is--open'; } ?>"><a href="/account.php">Account</a></li>
		</ul>
	</div>
</nav>

<?php

	// show any prompts

	$prompt = $_GET['prompt'];

	if ($prompt == 'notfound') {
		echo '<aside class="prompt is--prompted is--warning is--inline block">We couldn&rsquo;t find that match! It may have been cancelled.</aside>';
	}

	elseif ($prompt == 'disputed') {
		echo '<aside class="prompt is--prompted is--warning is--inline block">Your dispute has been recorded. Hold tight.</aside>';
	}

?>