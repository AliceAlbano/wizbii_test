<?php

require 'MeasureChecker.php';

class StockRequest
{
	private $_measure;

	public function __construct($measure) {
		$this->_measure = $measure;
	}

	public function insert_request() {
		$m = new MongoClient();

		$db = $m->analytics;
		$collection = $db->analytics;

		$collection->insert($this->_measure);
	}
}
