<article class="login">

	<?php /* <img src="/src/img/logo.svg" alt="Bandit Logo" class="logo" /> */ ?>

	<form id="login" class="block table login-form" method="post" action="<?=$_SERVER['PHP_SELF']?>">

		<fieldset class="row">

			<label for="player" class="h4">Player</label>

			<select name="player" id="player">
				<option selected value="choose">Find your account:</option>
				<?php
					foreach ($players as $player) {
						echo '<option value="' . $player['id'] . '">' . $player['name'] . '</option>';
					}
				?>
			</select>

		</fieldset>
		
		<fieldset class="row">

			<label for="player" class="h4">Password</label>

			<input type="password" name="password" required>

		</fieldset>
		
		<button type="submit" class="button">Login</button>
		
	</form>

</article>