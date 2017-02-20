<?php

require 'MeasureDescription.php';

class MeasureChecker
{

	private $_collected;

// XXX : At the moment the constructor is initialized with the data we want to
//       check. If we want to re-use the checker to verify various measures it
//       would be more effective to initialize the checker with the format
//       description.
	public function __construct($collected) {
		$this->_collected = $collected;
	}

// XXX : verify_measure_format
// XXX : We might want to move the exit in the problem handler methods to
//       ensure the atomicity of (error, exit)
	public function valid_description($measure) {
		$existence_ok = $measure->existing_parameters($this->_collected);
		if (!$existence_ok) {
			$this->existing_problem();
			exit;
		}
		$syntax_ok = $measure->valid_parameters($this->_collected);
		if (!$syntax_ok) {
			$this->valid_problem();
			exit;
		}
		$mandatory_ok = $measure->mandatory_parameters($this->_collected);
		if (!$mandatory_ok) {
			$this->mandatory_problem();
			exit;
		}
		return True;
	}

	private function mandatory_problem() {
		header('HTTP/1.0 400 Bad Request');
		echo "Error 400 Bad Request : missing parameter\n";
	}

	private function existing_problem() {
		header('HTTP/1.0 400 Bad Request');
		echo "Error 400 Bad Request : unknown parameter\n";
	}

	private function valid_problem() {
		header('HTTP/1.0 400 Bad Request');
		echo "Error 400 Bad Request : wrong format for parameter\n";
	}

}
