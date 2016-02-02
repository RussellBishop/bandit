<ul class="g1 player-stats">
	
	<li>
		<dt>Rating</dt>
		<dd><?=$playerStats['rating']?></dd>
	</li>
	
	<li>
		<dt>Position</dt>
		<dd><a href="leaderboard.php">#<?php echo playerPosition($player['id']); ?></a></dd>
	</li>
	
	<li>
		<dt>Win Ratio</dt>
		<dd><?php echo winLossRatio($player['id']);?></dd>
	</li>

</ul>