<?php
	
	require_once('src/config.php');
	
	require($src.'libs/medoo/medoo.php');
	
	require($data.'database.php');
	require_once($data.'players.php');
	require_once($data.'ratings.php');
	
	require_once($src.'auth/authenticate.php');
	
	require_once($functions.'functions.php');
	
	require($template.'header.php');
	require($template.'navigation.php');
	
?>

<?php $yourLevel = show_level($you['id']); ?>

<figure class="block player-card --level<?php echo $yourLevel['id']; ?>">

	<header class="player-identity">

		<h1 class="player-name h1"><?=$you['name']?></h1>
		
		<a href="/account.php" class="go-to-account">

			<?php
				
				playerPhoto($you['id']);
				
			?>
			
			<div class="player-level"><?php echo $yourLevel['level']; ?></div>
		</a>
	
	</header>
	
	<ul class="g1 player-stats">
		
		<li>
			<dt>Rating</dt>
			<dd><?php showRating($you); ?></dd>
		</li>
		
		<li>
			<dt>Position</dt>
			<dd>#2</dd>
		</li>
		
		<li>
			<dt>Win Ratio</dt>
			<dd><?php winLossRatio($you['id']);?></dd>
		</li>

    </ul>
    
</figure>

<ol class="block table">
	
	
	<?php
		/*
	<li>
		<h3 class="h3">Last game:</h3>
		<p>
			<?php
				
	    	$lastGame = $database->select('matches',
					[
						'datetime',
					],
					
					[
						'AND' => [
							'OR' => [
								'winner' => $you['id'],
								'loser' => $you['id']
							],
							'accepted' => '1',
						],
						
						"ORDER" => "datetime DESC",
						"LIMIT" => 1
					]
				);
				
				echo timeSince(strtotime($lastGame[0]['datetime'])).' ago';
				
			?>
		</p>
	</li>
		*/
	?>
	
	<li>
		<h3 class="h3">Games played:</h3>
		<p>
			<?php
				
		    	$gamesPlayed = $database->count('matches',
					[
						'id',
					],
					
					[
						'AND' => [
							'OR' => [
								'winner' => $you['id'],
								'loser' => $you['id']
							],
							'accepted' => '1',
						],
					]
				);
				
				$gamesWon = $database->count('matches',
					[
						'id',
					],
					
					[
						'AND' => [
							'winner' => $you['id'],
							'accepted' => '1',
						],
					]
				);
				
				$gamesLost = $database->count('matches',
					[
						'id',
					],
					
					[
						'AND' => [
							'loser' => $you['id'],
							'accepted' => '1',
						],
					]
				);
				
				echo $gamesPlayed .' Total (' .$gamesWon.' won / ' .$gamesLost.' lost)';
				
			?>
		</p>
	</li>
	
	<li>
		<h3 class="h3">Best win:</h3>
		<p>
			<?php
				
		    	$bestWin = $database->select('matches',
					[
						'[><]players (winner)' => ['winner' => 'id'],
						'[><]players (loser)' => ['loser' => 'id'],
					],
					
					[
						'matches.id',
						'matches.datetime',
						'matches.sent-by',
						'winner.id(winner-id)',
						'loser.id(loser-id)',
						'winner.name(winner-name)',
						'loser.name(loser-name)',
						'loser.photo(loser-photo)',
						'matches.winner',
						'matches.loser',
						'matches.accepted',
						'matches.declined',
						'matches.winner-original-rating',
						'matches.loser-original-rating',
					],
					
					[
						'AND' => [
							'OR' => [
								'winner' => $you['id']
							],
							'accepted' => '1',
						],
						
						"ORDER" => "matches.loser-original-rating DESC",
						"LIMIT" => 1
					]
					
				);
				
				
				echo '<a href="/result.php?result=' .$bestWin[0]['id']. '">';
				echo 'Versus. ';
				playerPhotoInline($bestWin[0]['loser-id']);
				echo ' ' .$bestWin[0]['loser-name']. ' (' .$bestWin[0]['loser-original-rating']. ')';
				echo '</a>';
				
			?>
		</p>
	</li>
	
	<li>
		<h3 class="h3">Best streak:</h3>
		<p>X games over Y period</p>
	</li>
	
</ol>

<section class="block results">
    
	<ul>
    
<?php
	
	$mostRecentResults = $database->select('matches',
			[
				'[><]players (winner)' => ['winner' => 'id'],
				'[><]players (loser)' => ['loser' => 'id'],
			],
			
			[
				'matches.id',
				'matches.datetime',
				'matches.sent-by',
				'winner.id(winner-id)',
				'loser.id(loser-id)',
				'winner.name(winner-name)',
				'loser.name(loser-name)',
				'matches.winner',
				'matches.loser',
				'matches.accepted',
				'matches.declined',
				'matches.winner-original-rating',
				'matches.loser-original-rating',
				'matches.difference',
				'matches.winner-new-rating',
				'matches.loser-new-rating'
			],
			
			[
				'AND' => [
					'OR' => [
						'winner' => $you['id'],
						'loser' => $you['id']
					],
				],
				
				"ORDER" => "matches.datetime DESC",
				"LIMIT" => 5
			]
		);
		
		foreach ($mostRecentResults as $result) {
			
			if ($result['accepted'] == 0) {
				
				echo '
				
				<li>
					<a href="/result?id='.$result['id'].'" class="g2 result --pending">
						
						<div class="base"></div>
						
							<div class="col1 player --a">
								';
								
								playerPhoto($result['winner-id']);
								
								echo '
								<div class="difference">Win</div>
							</div>
							
							<div class="col2 player --b">
								';
								
								playerPhoto($result['loser-id']);
								
								echo '
								<div class="difference">Loss</div>
							</div>
							
						<p class="meta --bottom --pending">Pending</p>
						
					</a>
				</li>
				
				';
				
			}
			
			else {
				
				echo '
				<li>
					<a href="/result?id='.$result['id'].'" class="g2 result">
					
						<div class="base"></div>
						
							<div class="col1 player --a --winner">
							
								<figure class="position-triangle">'
								.file_get_contents('src/img/position-triangle.svg').
								'</figure>';
								
								playerPhoto($result['winner-id']);
								
								echo '
								<div class="difference">+'. $result['difference'] .'</div>
							</div>
							
							<div class="col2 player --b --loser">
							
								<figure class="position-triangle">'
								.file_get_contents('src/img/position-triangle.svg').
								'</figure>';
								
								playerPhoto($result['loser-id']);
								
								echo '
								<div class="difference">-'. $result['difference'] .'</div>
							</div>
						
						<p class="meta --bottom --when">'. timeSince(strtotime($result['datetime'])) .' ago</p>
						
					</a>
				</li>';
				
			}
		
		}
		
?>

</section>

<?php
	require($template.'footer.php');
?>

<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>

<?php /*
	
<script src="/src/js/countTo.js"></script>
	
<script src="/src/js/addResult.js"></script>
<script>
	$('select').change(function() {
    
	    var value = $(this).val();
	 
	    $(this).siblings('select').children('option').each(function() {
	        if ( $(this).val() === value ) {
	            $(this).attr('disabled', true).siblings().removeAttr('disabled');   
	        }
	    });
	    
	});
</script>

*/ ?>

<?php
	require($template.'endHtml.php');
?>