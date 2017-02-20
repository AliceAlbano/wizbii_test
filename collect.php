<?php

require 'StockRequest.php';

// XXX : Here we're expecting an organisation like :
//       1) get measure (from GET or POST method)
//       2) check measure
//       3) Record measure if valid or return an error

// XXX : measure should be renamed description to not confuse collect input
//       with the description of a valid input
$measure = new MeasureDescription;

$data = file_get_contents('php://input');
$data = json_decode($data, true)[0];

$measure->set_qt_max(3600);

if (!empty($data)) {
	$validMeasure = new MeasureChecker($data);
} else {
	$data = $_GET;
	$validMeasure = new MeasureChecker($data);
}

$validMeasure->valid_description($measure);
if ($validMeasure) {
	$stockrequest = new StockRequest($data);
	$stockrequest->insertRequest();
}
