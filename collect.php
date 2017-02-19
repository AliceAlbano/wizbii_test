<?php

$t_values = array('pageview', 'screenview', 'event');
$v_values = array(1);
$tid_values = array('UA-XXXX-Y');

$mandatory_fields = array(
	't' => $t_values,
	'v' => $v_values,
	'tid' => $tid_values
	);

foreach($mandatory_fields as $field => $value){

	if ((!array_key_exists($field, $_GET)) OR
		(!in_array($_GET[$field], $value))){
		header('HTTP/1.0 400 Bad Request');
		echo "Error 400 Bad Request : field t missing\n";
		exit;
	}
}

