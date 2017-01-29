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

<?php

	$trueRating = $playerStats['rating'] / 5;

	$roundedUp = roundUpToAny($trueRating, 100);
	$remainder = $roundedUp - $trueRating;
	$percentage = 100 - $remainder;

	switch ($roundedUp) {

		case 900:
	        $nextLevel = 'Scout';
	        $levelId = 3;
	        break;

		case 1000:
	        $nextLevel = 'Scout';
	        $levelId = 3;
	        break;

		case 1100:
	        $nextLevel = 'Scout';
	        $levelId = 3;
	        break;

	    case 1200:
	        $nextLevel = 'Intermediate';
	        $levelId = 4;
	        break;

	    case 1300:
	        $nextLevel = 'Fighter';
	        $levelId = 5;
	        break;

	    case 1400:
	        $nextLevel = 'Knight';
	        $levelId = 6;
	        break;

	    case 1500:
	        $nextLevel = 'Assassin';
	        $levelId = 7;
	        break;
	}



	if ($trueRating < 850) {
		$levelId = 2;
		$percentage = ($trueRating / 850) * 100;
	}

	else if ((850 <= $trueRating) && ($trueRating <= 1099)) {
		$levelId = 3;
		$remainder = 1100 - $trueRating;
		$percentage = 100 - (($remainder / 250) * 100);
	}

?>

<ul class="player-levelUp is--level<?=$levelId?>">


	<figure class="progress" style="width: <?=$percentage?>%;"></figure>

	<h3 class="h4">Level Up</h3>

	<?php

		if ($trueRating < 850) {
			echo ((($trueRating - 850) * -1) * 5) . ' points to level up to Rookie';
		}

		else {

			echo $remainder*5 . ' points to level up to <span class="level-name">' . $nextLevel . '</span>';

		}

	?>


</ul>

<?php

	$ratingsArray = $database->select('matches',

			[
				'id',
				'datetime',
				'winner',
				'loser',
				'winner-original-rating',
				'loser-original-rating',
				'winner-new-rating',
				'loser-new-rating',
			],

			[
				'AND' => [
					'accepted' => 1,
					'declined' => 0,
					"datetime[<]" => date("Y-m-d 00:00:00", strtotime('-30 days')),

					'OR' => [
						'winner' => $player['id'],
						'loser' => $player['id']
					],
				],
				
				"ORDER" => "datetime ASC",
			]
			
		);

		print_r($ratingsArray);

?>