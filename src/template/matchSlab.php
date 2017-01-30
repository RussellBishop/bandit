<a href="/match.php?match=<?=$match['id']?>" class="g2 slate is--result<?=$isDisputed?>">

	<div class="base"></div>

	<div class="col1 player is--a is--winner is--level<?=$winnerStats['levelId']?>">
	
		<figure class="position-triangle">
		<?=file_get_contents($root.'dist/img/position-triangle.svg')?>
		</figure>
		
		<?php playerPhoto($match['winner-id']); ?>
		
		<div class="difference">+<span class="count"><?=$match['winner-difference']*5?></span></div>
	</div>
	
	<div class="col2 player is--b is--loser is--level<?=$loserStats['levelId']?>">
	
		<figure class="position-triangle">
		<?=file_get_contents($root.'dist/img/position-triangle.svg')?>
		</figure>
		
		<?php playerPhoto($match['loser-id']); ?>
		
		<div class="difference">-<span class="count"><?=$match['loser-difference']*5?></span></div>
	</div>			

</a>