<?php

class MeasureDescription
{
	//XXX: How can we know if it is a mobile hit ?
	//We don't implement these paramaters for now.
	private $_mandatory = array('t', 'v', 'tid', 'ds');
	private $_existing = array('t', 'v', 'tid', 'ds', 'ec', 'ea', 'sn', 'qt');

	private $_format = array(
		't' => "#^pageview$|^screenview$|^event$#",
		'v' => "#^1$#",
		'tid' => "#^UA-XXXX-Y$#",
		'ds' => "#^apps$|^web$|^backend$#",
		'ec' => "#[\s\S]#",
		'ea' => "#[\s\S]#",
		'sn' => "#[\s\S]#",
		'qt' => "#[0-9]+#"
		);

	private $_qt_max = 3600;

	public function set_qt_max($value) {
		$this->_qt_max = $value;
	}

	private function add_mandatory_parameter($parameter) {
		array_push($this->_mandatory, $parameter);
	}

//Change mandatory parameters according to t value
	private function conditional_hit_type($value) {
		if ($value == 'event') {
			$this->add_mandatory_parameter('ec');
			$this->add_mandatory_parameter('ea');
		}
		if ($value == 'screenview')
			$this->add_mandatory_parameter('sn');
	}

	public function mandatory_parameters($given){
		foreach ($this->_mandatory as $field) {
			if (!array_key_exists($field, $given)) {
				echo "$field presence is required. </br>\n";
				return False;
			}
		}
		return True;

	}

	public function existing_parameters($given){
		foreach ($given as $field => $value) {
			if (!in_array($field, $this->_existing)) {
				echo "$field does not exist. </br>\n";
				return False;
			}
		}
		return True;
	}

	public function valid_parameters($given){
		foreach ($given as $field => $value) {
			$regexp = ($this->_format[$field]);
			if (preg_match($regexp, $value) == 0) {
				echo "$value is not a valid format for $field. </br>\n";
				return False;
			}

			if ($field == 't')
				$this->conditional_hit_type($value);

			if ($field == 'qt') {
				if ($value > $this->_qt_max) {
					echo "qt is too high </br>\n";
					return False;
				}
			}
		}
		return True;

	}

}
