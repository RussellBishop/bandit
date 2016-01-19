<?php
	
	require_once('src/config.php');
	
	require_once($src.'libs/medoo/medoo.php');
	
	require_once($data.'database.php');
	require_once($data.'players.php');
	
	require_once('src/auth/authenticate.php');
	require($template.'header.php');
	require($template.'navigation.php');
	
	$view = 'account';
	
?>



<form id="updateAccount" method="post" action="<?=$actions?>updateAccount.php" enctype="multipart/form-data">
	
	<fieldset>
		
		<label for="player-photo" style="background: url('/upload/player-photo/<?=$you['photo']?>') no-repeat;">Choose a photo&hellip;</label>
		<input type="file" name="player-photo" id="player-photo">
		
	</fieldset>
	
	<fieldset>
		
		<label for="fullName">Full Name</label>
		<input type="text" name="fullName" id="fullName" value="<?=$you['name']?>" />
		
	</fieldset>
	
	<fieldset>
		
		<label for="email">Email</label>
		<input type="text" name="email" id="email" value="<?=$you['email']?>" />
		
	</fieldset>
	
	<fieldset>
		
		<label for="password">Password</label>
		<input type="password" name="password" id="password" />
		
	</fieldset>
	
	<button class="button" type="submit">Update my profile</button>
	
</form>

<?php
	
	require('src/template/footer.php');
	
?>