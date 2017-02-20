<?php

require 'MeasureChecker.php';

class StockRequest
{
	private $_measure;

	public function __construct($measure) {
		$this->_measure = $measure;
	}

	public function insertRequest() {
		$m = new MongoClient();
		echo "Connexion ok <br />\n";

		$db = $m->analytics;
		$collection = $db->analytics;
		echo "Database analytics selected <br />\n";

		$collection->insert($this->_measure);
		echo "Document inserted successfully <br />\n";
	}
}
