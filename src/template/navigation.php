<?php
	
	$playerStats = playerStats($you['id']);
		
?>

<nav class="menu g5">

	<a class="menu__logo" href="/"><?php echo file_get_contents($root.'dist/img/logo.svg'); ?></a>

	<label class="menu__toggle" data-toggles="menu">
		<div class="player-photo-wrap is--level<?=$playerStats['levelId']?>"><?php playerPhoto($you['id']); ?></div>
		<figure class="menu__icon"><?php echo file_get_contents($root.'dist/img/menu.svg'); ?></figure>
	</label>

</nav>

<div class="fullscreen is--menu" data-is="menu">

		<label class="close" data-toggles="menu">&times;</label>

		<ul>
			<li class="<?php if ($view == 'profile') { echo 'is--open'; } ?>"><a href="/">Profile</a></li>
			<li class="<?php if ($view == 'add-win') { echo 'is--open'; } ?>"><a href="/add-win.php">Add Wins</a></li>
			<li class="<?php if ($view == 'matches') { echo 'is--open'; } ?>"><a href="/matches.php">Matches</a></li>
			<li class="<?php if ($view == 'leaderboard') { echo 'is--open'; } ?>"><a href="/leaderboard.php">Leaderboard</a></li>
			<li class="<?php if ($view == 'account') { echo 'is--open'; } ?>"><a href="/account.php">Account</a></li>

			<?php if ($you['role'] == 'admin') : ?><li class="<?php if ($view == 'invite-players') { echo 'is--open'; } ?>"><a href="/invite-player.php">Invite Players</a></li><?php endif; ?>
		</ul>
	</div>

<?php

	// show any prompts
	$prompt = $_GET['prompt'];

	if ($prompt == 'notfound') {
		echo '<aside class="prompt is--prompted is--warning is--inline block">We couldn&rsquo;t find that match! It may have been cancelled.</aside>';
	}

	elseif ($prompt == 'disputed') {
		echo '<aside class="prompt is--prompted is--warning is--inline block">Your dispute has cancelled the result. Your opponent has been notified.</aside>';
	}

	elseif ($prompt == 'emailexists') {
		echo '<aside class="prompt is--prompted is--warning is--inline block">This email address is already in use!</aside>';
	}

	elseif ($prompt == 'unfinishedform') {
		echo '<aside class="prompt is--prompted is--warning is--inline block">Please fill in all of the fields.</aside>';
	}

?>