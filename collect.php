<?php

//XXX: How can we know if it is a mobile hit ?
//We don't implement these paramaters for now.

$mandatory_fields = array('t', 'v', 'tid', 'ds');

$field_values = array(
	't' => array('pageview', 'screenview', 'event'),
	'v' => array(1),
	'tid' => array('UA-XXXX-Y'),
	'ds' => array('web', 'apps', 'backend'),
	'ec' => array('bdo'),
	'ea' => array('client'),
	'sn' => array('jobs'),
	);

function check_parameters_existence($existing, $given) {
	foreach ($given as $field => $value) {
		if (!array_key_exists($field, $existing))
			return False;
	}
	return True;
}

function check_parameters_syntax($reference, $given, &$mandatory) {
	foreach ($given as $field => $value) {
		if (!in_array($value, $reference[$field])) {
			return False;
		}
		
		//Conditional paramaters according to t value (hit type)
		if ($field == 't') {
			if ($value == 'event')
				array_push($mandatory, 'ec', 'ea');
			if ($value == 'screenview')
				array_push($mandatory, 'sn');
		}
	}
	return True;
}

function check_mandatory_parameters_presence($mandatory, $given) {
	foreach ($mandatory as $field) {
		if (!array_key_exists($field, $given))
			return False;
	}
	return True;
}

$existence_ok = check_parameters_existence($field_values, $_GET);
$syntax_ok = check_parameters_syntax($field_values, $_GET, $mandatory_fields);
$mandatory_ok = check_mandatory_parameters_presence($mandatory_fields, $_GET);

if (!$existence_ok OR !$mandatory_ok or !$syntax_ok) {
	header('HTTP/1.0 400 Bad Request');
	echo "Error 400 Bad Request\n";
	exit;
}
