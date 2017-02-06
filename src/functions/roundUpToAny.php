<?php

	function roundUpToAny($n,$x=100) {

	    return round(($n+$x/2)/$x)*$x;

	}

?>