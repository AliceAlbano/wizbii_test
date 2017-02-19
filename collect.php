<?php

require 'MeasureChecker.php';

$measure = new MeasureDescription;
$measureChecker = new MeasureChecker;

$measureChecker->valid_description($measure);
