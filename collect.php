<?php

$mandatory_fields = array(
	't' => 'pageview',
	'v' => 1,
	'tid' => 'UA-XXXX-Y'
	);

foreach($mandatory_fields as $field => $value){

	if (!array_key_exists($field, $_GET)){
		header('HTTP/1.0 400 Bad Request');
		echo "Error 400 Bad Request : field t missing\n";
		exit;
	}
}

