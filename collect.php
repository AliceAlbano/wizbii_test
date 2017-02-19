<?php

require 'MeasureDescription.php';

$measure = new MeasureDescription;

$existence_ok = $measure->existing_parameters($_GET);
$syntax_ok = $measure->valid_parameters($_GET);
$mandatory_ok = $measure->mandatory_parameters($_GET);

if (!$existence_ok OR !$mandatory_ok OR !$syntax_ok) {
	header('HTTP/1.0 400 Bad Request');
	echo "Error 400 Bad Request\n";
	exit;
}
