<?php

	$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

		$database = new medoo([
	    'database_type' => 'mysql',
	    'database_name' => 'cakephp',
	    'server' => '192.168.99.100',
	    'username' => 'docker',
	    'password' => 'secret',
	    'charset' => 'utf8'
	]);
	
?>