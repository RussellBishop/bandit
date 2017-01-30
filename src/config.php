<?php

	$url = $_SERVER['REQUEST_URI'];
	$root = $_SERVER['DOCUMENT_ROOT'] . '/';			//			/
	
	$src = $root . 'src/';								//			/src/
	$data = $src . 'data/';								//			/src/data/
	$functions = $src . 'functions/';					//			/src/functions/
	$template = $src . 'template/';						//			/src/template/

	// where are the assets?
	$dist = '/dist/';
	$css = '/dist/css/';									//			/src/css/
	$img = '/dist/img/';									//			/src/img/
	$js = '/dist/js/';									//			/src/js/
	
	$upload = '/upload/';								//			/src/upload/
	$uploadPlayerPhoto = $upload.'player-photo/';		//			/src/upload/player-photo/
	
	$actions = '/src/actions/';							//			/
	
	date_default_timezone_set('Europe/London');
	
	// load medoo and get database info
	require_once($src.'libs/medoo/medoo.php');
	require_once($data.'database.php');

	require_once($src.'auth/authenticate.php');

?>