<?php

$mandatory_fields = array(
	't' => array('pageview', 'screenview', 'event'),
	'v' => array(1),
	'tid' => array('UA-XXXX-Y'),
	'ds' => array('web', 'apps', 'backend'),
	);

function check_parameters($mandatory, $given) {
	foreach ($mandatory as $field => $value) {
		if (!array_key_exists($field, $given))
			return False;

		if (!in_array($given[$field], $value))
			return False;
	}
	return True;
}

$syntax_ok = check_parameters($mandatory_fields, $_GET);
if (!$syntax_ok) {
	header('HTTP/1.0 400 Bad Request');
	echo "Error 400 Bad Request : field t missing\n";
	exit;
}
