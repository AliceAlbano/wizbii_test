<?php

$t_values = array('pageview', 'screenview', 'event');
$v_values = array(1);
$tid_values = array('UA-XXXX-Y');

$mandatory_fields = array(
	't' => $t_values,
	'v' => $v_values,
	'tid' => $tid_values
	);

function check_parameters($mandatory, $given){
	foreach ($mandatory as $field => $value){
		if ((!array_key_exists($field, $given)) OR
			(!in_array($given[$field], $value))){
			return False;
		}
	}
	return True;
}

$syntax_ok = check_parameters($mandatory_fields, $_GET);
if (!$syntax_ok){
	header('HTTP/1.0 400 Bad Request');
	echo "Error 400 Bad Request : field t missing\n";
	exit;
}
