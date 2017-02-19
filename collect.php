<?php

//XXX: How can we know if it is a mobile hit ?
//We don't implement these paramaters for now.
$mandatory_fields = array(
	't' => array('pageview', 'screenview', 'event'),
	'v' => array(1),
	'tid' => array('UA-XXXX-Y'),
	'ds' => array('web', 'apps', 'backend'),
	);

function check_parameters_presence($mandatory, $given) {
	foreach ($mandatory as $field => $value) {
		if (!array_key_exists($field, $given))
			return False;
	}
	return True;
}

function check_parameters_syntax($expected, $given) {
	foreach ($given as $field => $value) {
		if (!in_array($value, $expected[$field]))
			return False;
	}
	return True;
}

$presence_ok = check_parameters_presence($mandatory_fields, $_GET);
$syntax_ok = check_parameters_syntax($mandatory_fields, $_GET);
if (!$presence_ok OR !$syntax_ok) {
	header('HTTP/1.0 400 Bad Request');
	echo "Error 400 Bad Request : field t missing\n";
	exit;
}
