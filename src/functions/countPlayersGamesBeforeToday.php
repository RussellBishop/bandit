<?php

	function countPlayersGamesBeforeToday($id) {

		global $database;

		$countPlayersGamesBeforeToday = $database->count('matches',

			[

				'AND' => [
					'accepted' => 1,
					'declined' => 0,
					'datetime[<]' => date("Y-m-d 00:00:00"),

					'OR' => [
						'winner' => $id,
						'loser' => $id
					],
				],

			]

		);

		return $countPlayersGamesBeforeToday;

	}

?>