<?php

	$view = 'add-win';

	require_once('src/config.php');

	require_once($data.'players.php');
	require_once($data.'ratings.php');
		
	require_once($functions.'functions.php');
	
	require($template.'header.php');
	require($template.'navigation.php');
	
?>

<h1 class="h1">Who won?</h1>

<form class="block table is--result" method="post" action="<?=$actions.'testResults.php';?>">

	<ol class="block table">

			<select name="winner" id="opponent" required>
				<option value="" disabled selected>Choose today's winner</option>
				<?php
			
					foreach ($players as $player) {
						
							echo '<option value="' . $player['id'] . '">' . $player['name'] . '</option>';
						
					}
			
				?>
			</select>

		<li class="row">

			<select name="opponent" id="opponent" required>
				<option value="" disabled selected>Choose today's opponent</option>
				<?php
			
					foreach ($players as $player) {
						
							echo '<option value="' . $player['id'] . '">' . $player['name'] . '</option>';
						
					}
			
				?>
			</select>

		</li>

		<li class="row">

			<div class="stepper g1">
			    <div><button type="button" class="button is--disabled is--decrease" data-decrease>-</button></div>
			    <div><input type="text" value="1" min="1" max="20" name="winCount" id="winCount" /></div>
			    <div><button type="button" class="button is--good is--increase" data-increase>+</button></div>
			</div>

		</li>

		<p class="prompt is--inline is--prompted is--warning is--faded">Make sure this information is correct, or risk penalties!</p>

		<li>
			<button type="submit" class="button is--good" name="submit">Add My Wins</button>
		</li>

	</ol>

</form>

<?php

	require($template.'footer.php');

?>

<script>

	$('.stepper').inputStepper({
	    selectorButtonIncrease: '.is--increase',
	    selectorButtonDecrease: '.is--decrease',
	    dataAttributeIncrease: 'increase',
	    dataAttributeDecrease: 'decrease'
	});

</script>

<?php

	require($template.'endHtml.php');
	
?>