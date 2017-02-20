<?php

require 'StockRequest.php';

$measure = new MeasureDescription;

	$data = file_get_contents('php://input');
	$data = json_decode($data, true)[0];

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
