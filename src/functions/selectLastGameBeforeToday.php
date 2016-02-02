<?php

	function selectLastGameBeforeToday($id) {

		global $database;

		$lastGameArray = $database->select('matches',

			[
				'matches.id',
				'matches.winner',
				'matches.loser',
				'matches.winner-original-rating',
				'matches.loser-original-rating',
			],

			[
				'AND' => [
					'declined' => 0,

					'OR' => [
						'winner' => $id,
						'loser' => $id
					],
				],
				
				"ORDER" => "matches.datetime DESC",
				"LIMIT" => 1,
				"matches.datetime[<]" => date("Y-m-d 00:00:00")
			]
			
		);

		$lastGame = $lastGameArray[0];

		return $lastGame;

	}

?>