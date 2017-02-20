<?php

require 'StockRequest.php';

// Get the measure
$data = file_get_contents('php://input');
$data = json_decode($data, true)[0];

if (empty($data))
	$data = $_GET;

//Check the measure
$description = new MeasureDescription;
$description->set_qt_max(3600);

$validMeasure = new MeasureChecker($description);
$validMeasure->valid_description($data);

//Record measure if valid
if ($validMeasure) {
	$stockrequest = new StockRequest($data);
	$stockrequest->insertRequest();
}
