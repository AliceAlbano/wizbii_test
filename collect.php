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

$valid_measure = new MeasureChecker($description);
$valid_measure->valid_description($data);

//Record measure if valid
if ($valid_measure) {
	$stock_request = new StockRequest($data);
	$stock_request->insert_request();
}
