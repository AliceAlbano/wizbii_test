<?php

require 'StockRequest.php';

$measure = new MeasureDescription;
$validMeasure = new MeasureChecker($_GET);

$validMeasure->valid_description($measure);
if ($validMeasure) {
	$stockrequest = new StockRequest($_GET);
	$stockrequest->insertRequest();
}
