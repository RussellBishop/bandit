<?php

	$view = 'add-result';

	require_once('src/config.php');

	require_once($data.'players.php');
	require_once($data.'ratings.php');
		
	require_once($functions.'functions.php');
	
	require($template.'header.php');
	require($template.'navigation.php');
	
?>

<h1 class="h1">Add result</h1>

<form class="block table" method="post" action="<?=$actions.'addResult.php';?>">

	<ol class="block table">

	<li class="row">

		<label for="opponent" class="h4">You played:</label>

		<select name="opponent" id="opponent" required>
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

	</li>

	<li class="row g2">
		<p class="h4">Result:</p>
		<label for="iwon" class="col1 resultOption"><input type="radio" name="outcome" value="won" id="iwon" /> <span class="label">Win</span></label>
		<label for="ilost" class="col2 resultOption"><input type="radio" name="outcome" value="loss" id="ilost" /> <span class="label">Loss</span></label>
	</li>

	<?php $date = date('Y-m-d').'T'.date('H:i'); ?>

	<li class="row">
		<p class="h4">Date <em>(now)</em>:</p>
		<input type="datetime-local" name="datetime" required value="<?php echo $date; ?>" />
	</li>

	<li class="row">
		<button type="submit" name="submit">Send for confirmation</button>
	</li>

	</ol>

</form>

<?php

	require($template.'footer.php');

?>

<script src="<?=$js;?>global.min.js"></script>

<?php

	require($template.'endHtml.php');
	
?>