<?php

	$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	
	if (strpos($url,'localhost') == true) {
		
		$database = new medoo([
	    'database_type' => 'mysql',
	    'database_name' => 'bandit',
	    'server' => '127.0.0.1',
	    'username' => 'root',
	    'password' => 'login',
	    'charset' => 'utf8'
	]);

	}
	
	elseif (strpos($url,'bandit.russellbishop') == true) {
		
		$database = new medoo([
		    'database_type' => 'mysql',
		    'database_name' => 'russ_bandit',
		    'server' => 'localhost',
			'username' => 'russ_coin',
			'password' => 'insdj08921jd210',
			'charset' => 'utf8',
		]);
		
	}

	elseif (strpos($url,'banditplay.russellbishop') == true) {

		$database = new medoo([
		    'database_type' => 'mysql',
		    'database_name' => 'russ_banditplay',
		    'server' => 'localhost',
			'username' => 'russ_coin',
			'password' => 'insdj08921jd210',
			'charset' => 'utf8',
		]);
		
	}
	
?>