<?php
	
	function playerPhotoInline($id) {
		
		global $database;
		
		global $uploadPlayerPhoto;
		
		$player = $database->get('players',
		
			[
				'photo', 'name'
			],
			
			[
				'id' => $id
			]
			
		);
		
		if (!empty($player['photo'])) {
			echo '<span class="player-photo-inline" style="background-image: url('.$uploadPlayerPhoto.$player['photo'].');"></span>';
		}
		
	}
	
?>