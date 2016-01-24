<?php
	
	$view = 'account';

	require_once('src/config.php');
	
	require_once($src.'libs/medoo/medoo.php');
	
	require_once($data.'database.php');
	require_once($data.'players.php');
	
	require_once('src/auth/authenticate.php');

	require_once($functions.'functions.php');

	require($template.'header.php');
	require($template.'navigation.php');	
	
?>

<form id="updateAccount" class="block table account" method="post" action="<?=$actions?>updateAccount.php" enctype="multipart/form-data">
	
	<fieldset class="row is--photo">

		<label for="player-photo" class="player-photo-label">

			<?php playerPhoto($you['id']); ?>

			<input type="file" name="player-photo" id="player-photo">

		</label>
		
	</fieldset>
	
	<fieldset class="row">
		
		<label for="fullName" class="h4">Full Name</label>
		<input type="text" name="fullName" id="fullName" value="<?=$you['name']?>" />
		
	</fieldset>
	
	<fieldset class="row">
		
		<label for="email" class="h4">Email</label>
		<input type="text" name="email" id="email" value="<?=$you['email']?>" />
		
	</fieldset>
	
	<fieldset class="row">
		
		<label for="password" class="h4">New Password</label>
		<input type="password" name="password" id="password" />
		
	</fieldset>
	
	<button class="button" type="submit">Update my profile</button>
	
</form>

<a href="/logout.php">Logout</a>

<?php

	require($template.'footer.php');

?>

<script src="<?=$js;?>global.min.js"></script>

<?php

	require($template.'endHtml.php');
	
?>