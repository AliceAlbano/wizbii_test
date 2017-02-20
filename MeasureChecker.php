<?php

require 'MeasureDescription.php';

class MeasureChecker
{

	private $_description;

	public function __construct($description) {
		$this->_description = $description;
	}

	public function valid_description($measure) {
		$existence_ok = $this->_description->check_existing_parameters($measure);
		if (!$existence_ok)
			$this->existing_problem();

		$syntax_ok = $this->_description->check_valid_parameters($measure);
		if (!$syntax_ok)
			$this->valid_problem();

		$mandatory_ok = $this->_description->check_mandatory_parameters($measure);
		if (!$mandatory_ok)
			$this->mandatory_problem();
		return True;
	}

	private function mandatory_problem() {
		header('HTTP/1.0 400 Bad Request');
		echo "Error 400 Bad Request : missing parameter\n";
		exit;
	}

	private function existing_problem() {
		header('HTTP/1.0 400 Bad Request');
		echo "Error 400 Bad Request : unknown parameter\n";
		exit;
	}

	private function valid_problem() {
		header('HTTP/1.0 400 Bad Request');
		echo "Error 400 Bad Request : wrong format for parameter\n";
		exit;
	}

}
