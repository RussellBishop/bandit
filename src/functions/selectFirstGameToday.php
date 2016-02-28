<?php

	function selectFirstGameToday($id) {

		global $database;

		$firstGameArray = $database->select('matches',

			[
				'id',
				'datetime',
				'winner',
				'loser',
				'winner-original-rating',
				'loser-original-rating',
				'winner-new-rating',
				'loser-new-rating',
			],

			[
				'AND' => [
					'accepted' => 1,
					'declined' => 0,
					"datetime[<]" => date("Y-m-d 00:00:00", strtotime('+1 day')),

					'OR' => [
						'winner' => $id,
						'loser' => $id
					],
				],
				
				"ORDER" => "id ASC",
				"LIMIT" => 1
			]
			
		);

		$firstGame = $firstGameArray[0];

		return $firstGame;

	}

?>