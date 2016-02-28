<?php

	function countPlayersGames($id) {

		global $database;

		$countPlayersGames = $database->count('matches',

			[

				'AND' => [
					'accepted' => 1,
					'declined' => 0,

					'OR' => [
						'winner' => $id,
						'loser' => $id
					],
				],

			]

		);

		return $countPlayersGames;

	}

?>