<?php
	
	require_once('src/config.php');
	
	require_once($src.'libs/medoo/medoo.php');
	
	require_once($data.'database.php');
	require_once($data.'players.php');
	
	require_once($src.'auth/authenticate.php');
	
	require_once($functions.'functions.php');
	
	require($template.'header.php');
	require($template.'navigation.php');
	
?>

<h1>Players</h1>

<article class="block leaderboard">
	
	<ol>
	
	<?php
	
	$leaderboardPlayers = $database->select('players',
	
		[
			'id', 'name', 'photo', 'rating'
		],
		
		[
			"ORDER" => ['rating DESC']
		]
		
	);
	
	foreach ($leaderboardPlayers as $player) {

		$level = show_level($player['id']);
		
		echo '<li><div class="g3 result position --level' .$level['id'].(($player['id']==$you['id'])?' --you':""). '">
		
			<div class="base"></div>
			
			<div class="col1">';
			
			playerPhoto($player['id']);
			
			echo '
			</div>
			
			<header class="col2 player-info">
				<h1>' .$player['name']. '</h1>
				<h2 class="player-level">' .$level['level']. '</h2>
			</header>
			
			<aside class="col3 player-rating">
				<h3>' .$player['rating']. '</h3>
			</aside>
			
			';
		
		echo '</div></li>';
		
	}
	
	?>
	
	</ol>
		
</article>

<?php
	require($template.'footer.php');
?>

<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>

<?php
	require($template.'endHtml.php');
?>