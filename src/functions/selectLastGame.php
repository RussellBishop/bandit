<?php

	function selectLastGame($id) {

		global $database;

		$lastGame = $database->select('matches',
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
					'OR' => [
						'winner' => $id,
						'loser' => $id
					],
					'accepted' => '1',
					'declined' => '0',
				],
				
				"ORDER" => "sent-datetime DESC",
				"LIMIT" => 1
			]
		);

		return $lastGame[0];

	}

?>