<?php

require 'MeasureDescription.php';

class MeasureChecker
{

	public function valid_description($measure) {
		$existence_ok = $measure->existing_parameters($_GET);
		if (!$existence_ok) {
			$this->existing_problem();
			exit;
		}
		$syntax_ok = $measure->valid_parameters($_GET);
		if (!$syntax_ok) {
			$this->valid_problem();
			exit;
		}
		$mandatory_ok = $measure->mandatory_parameters($_GET);
		if (!$mandatory_ok) {
			$this->mandatory_problem();
			exit;
		}
		return True;
	}

	private function mandatory_problem(){
		header('HTTP/1.0 400 Bad Request');
		echo "Error 400 Bad Request : missing parameter\n";
	}

	private function existing_problem(){
		header('HTTP/1.0 400 Bad Request');
		echo "Error 400 Bad Request : unknown parameter\n";
	}

	private function valid_problem(){
		header('HTTP/1.0 400 Bad Request');
		echo "Error 400 Bad Request : wrong format for parameter\n";
	}

}
