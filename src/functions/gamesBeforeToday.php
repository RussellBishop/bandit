<?php

	function gamesBeforeToday($id) {

		global $database;

		$gamesBeforeToday = $database->count('matches',
			[
				'AND' => [
					'declined' => 0,

					'OR' => [
						'winner' => $id,
						'loser' => $id
					],
				],
				
				"matches.datetime[<]" => date("Y-m-d 00:00:00")
			]
		);

		return $gamesBeforeToday;

	}

?>