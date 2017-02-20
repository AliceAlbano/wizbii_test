<?php

require 'StockRequest.php';

$measure = new MeasureDescription;
$validMeasure = new MeasureChecker($_GET);

$validMeasure->valid_description($measure);
if ($validMeasure) {
	echo "On va inserer la requete";
	$stockrequest = new StockRequest($_GET);
	$stockrequest->insertRequest();
}
