<form id="login" method="post" action="<?=$_SERVER['PHP_SELF']?>">

	<fieldset>
		<select name="player" id="player">
			<option selected value="choose">Find your account:</option>
			<?php
				foreach ($players as $player) {
					echo '<option value="' . $player['id'] . '">' . $player['name'] . '</option>';
				}
			?>
		</select>
	</fieldset>
	
	<fieldset>
		<input type="password" name="password" required>
	</fieldset>
	
	<button type="submit">Login</button>
	
</form>