<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no"/>

<title>Bandit</title>

<?php if ($view == 'account') { echo '<link href="/src/css/account.css" type="text/css" rel="stylesheet" />'; } ?>

<style>
<?php echo file_get_contents($src.'css/critical.css'); ?>
</style>

<link href="/src/css/screen.css" type="text/css" rel="stylesheet" />

</head>

<body class="<?php if (!empty($view)) { echo 'view is--'.$view; } ?>">

<figure style="display: none;">
<?php echo file_get_contents('src/img/hexagon-border-symbol.svg'); ?>
</figure>

	<aside class="fullscreen is--loading">

		<svg width="40px" height="46px" viewBox="0 0 40 46" version="1.1" xmlns="http://www.w3.org/2000/svg" class="spinner" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
		    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
		        <polygon id="Polygon-1" stroke="#FFFFFF" stroke-width="4" sketch:type="MSShapeGroup" points="20 3 37.3205081 13 37.3205081 33 20 43 2.67949192 33 2.67949192 13 "></polygon>
		    </g>
		</svg>

	</aside>