<?php

	$view = 'add-win';

	require_once('src/config.php');

	require_once($data.'players.php');
	require_once($data.'ratings.php');
		
	require_once($functions.'functions.php');
	
	require($template.'header.php');
	require($template.'navigation.php');
	
?>

<h1 class="h1">You won against</h1>

<form class="block table is--result" method="post" action="<?=$actions.'addWin.php';?>">

	<ol class="block table">

	<li class="row">

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

	<li class="row">
		<input type="number" placeholder="How many wins?" min="1" />
	</li>

	<?php $date = date('Y-m-d').'T'.date('H:i'); ?>

	<li class="row">
		<input type="datetime-local" name="datetime" required value="<?php echo $date; ?>" />
	</li>

	<li class="row">
		<button type="submit" name="submit">Win</button>
	</li>

	</ol>

</form>

<?php

	require($template.'footer.php');

?>

<?php

	require($template.'endHtml.php');
	
?>