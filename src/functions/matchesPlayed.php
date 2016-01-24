<?php

	function matchesPlayed($id) {

		global $database;

		$matchesPlayed = $database->count('matches',
			[
				'AND' => [
					'OR' => [
						'winner' => $id,
						'loser' => $id
					],
					'accepted' => '1',
				],
			]
		);

		echo $matchesPlayed;

	}

?>