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

	<label class="menu__toggle" for="menu">
		<div class="player-photo-wrap is--level<?=$playerStats['levelId']?>"><?php playerPhoto($you['id']); ?></div>
		<figure class="menu__icon"><?php if ($notifications>0) { echo '<span class="new">'.$notifications.'</span>'; } ?></span><?php echo file_get_contents('src/img/menu.svg'); ?></figure>
	</label>

	<input class="toggle" name="menu" id="menu" type="checkbox" />

	<div class="fullscreen is--menu toggled">

		<label for="menu" class="close">X</label>

		<ul>
			<li class="<?php if ($view == 'profile') { echo 'is--open'; } ?>"><a href="/">My Profile</a></li>
			<li class="<?php if ($view == 'add-result') { echo 'is--open'; } ?>"><a href="/add-result.php">Add Result</a></li>
			<li class="<?php if ($view == 'matches') { echo 'is--open'; } ?>"><a href="/matches.php">Matches<?php if ($notifications>0) { echo '  ('.$notifications.' new)'; } ?></a></li>
			<li class="<?php if ($view == 'leaderboard') { echo 'is--open'; } ?>"><a href="/leaderboard.php">Leaderboard</a></li>
			<li class="<?php if ($view == 'account') { echo 'is--open'; } ?>"><a href="/account.php">Account</a></li>
		</ul>
	</div>
</nav>