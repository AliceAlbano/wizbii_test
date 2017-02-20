<?php

require 'StockRequest.php';

$measure = new MeasureDescription;

if (!empty($_POST)) {
	$validMeasure = new MeasureChecker($_POST);
	} else
	$validMeasure = new MeasureChecker($_GET);
	}

$validMeasure->valid_description($measure);
if ($validMeasure) {
	$stockrequest = new StockRequest($_GET);
	$stockrequest->insertRequest();
}
