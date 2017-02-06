<?php

	function selectLastGameBeforeToday($id) {

		global $database;

		$lastGameArray = $database->select('matches',

			[
				'id',
				'datetime',
				'sent-datetime',
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
					"datetime[<]" => date("Y-m-d 00:00:00"),

					'OR' => [
						'winner' => $id,
						'loser' => $id
					],
				],
				
				"ORDER" => "sent-datetime DESC",
				"LIMIT" => 3
			]
			
		);

		$lastGame = $lastGameArray[0];

		return $lastGame;

	}

?>