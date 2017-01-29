<?php

	require_once('src/config.php');

	require_once($data.'players.php');
	require_once($data.'ratings.php');
	
	require_once($src.'auth/authenticate.php');
	
	require_once($functions.'functions.php');
	
	require($template.'header.php');
	require($template.'navigation.php');
	
?>

<?php
	
	$playerId = $_GET['player'];
	require($template.'playerProfile.php');


		$ratingsArray = $database->select('matches',

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
					"datetime[<]" => date("Y-m-d 00:00:00", strtotime('-30 days')),

					'OR' => [
						'winner' => $id,
						'loser' => $id
					],
				],
				
				"ORDER" => "datetime ASC",
			]
			
		);

		print_r($ratingsArray);

?>

<?php

	require($template.'footer.php');

?>

<?php

	require($template.'endHtml.php');
	
?>