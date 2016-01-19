<?php
	
	function playerPhoto($id) {
		
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
			$playerPhotoBackground = 'background-image: url('.$uploadPlayerPhoto.$player['photo'].');';
		}
		else {
			$playerPhotoBackground = '';
		}
		
		echo '
		
			<figure class="player-photo" data-acronym="';
			
			acronym($player['name']);
			
			echo
			
			'">'
			.file_get_contents('src/img/hexagon-border.svg').
			'
				
				<div class="photo-border">
					<div class="colour"></div>
					<div class="photo" style="'.$playerPhotoBackground.'"></div>
				</div>
			</figure>
			
			';
	
	}
			
?>