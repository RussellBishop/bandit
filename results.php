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

<section class="block results">

<h1 class="h1">Results</h1>

<ul>

	<?php
		
		$results = $database->select('matches',
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
				'accepted' => '1',
				"ORDER" => "matches.datetime DESC",
				"LIMIT" => 20
			]
		);
		
		foreach ($results as $result) {
			
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
		
	?>
	
</ul>
	
</section>


<h1>Add Result</h1>

<form id="addResult" method="post" action="src/actions/addResult.php">
	
	<input type="hidden" name="sent-by" value="<?=$you['id']?>" />
	
	<fieldset>
		
		<label for="opponent">Opponent:</label>
		
		<select name="opponent">
			<option value="" disabled selected>Choose an opponent</option>
			<?php
		
				foreach ($players as $player) {
					
					if ($player['id'] != $you['id'])
					{
						echo '<option value="' . $player['id'] . '">' . $player['name'] . '</option>';
					}
					
				}
		
			?>
		</select>
		
	</fieldset>
	
	<fieldset>
		
		<input type="checkbox" id="outcome" name="outcome" value="1" checked />
		
			<label for="outcome" class="label">
				<span class="win">Win</span>
				<span class="loss">Loss</span>
			</label>
			
	</fieldset>
	
	<button class="btn btn-success">Send for confirmation</button>
	
</form>

<hr />

<hr />

<h2>Pending Results</h2>


<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>



