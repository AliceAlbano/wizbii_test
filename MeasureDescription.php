<?php

class MeasureDescription
{
	private $_mandatory = array('t', 'v', 'tid', 'ds');
	private $_existing = array('t', 'v', 'tid', 'ds', 'ec', 'ea', 'sn');
	private $_format = array(
		't' => array('pageview', 'screenview', 'event'),
		'v' => array(1),
		'tid' => array('UA-XXXX-Y'),
		'ds' => array('web', 'apps', 'backend'),
		'ec' => array('bdo'),
		'ea' => array('client'),
		'sn' => array('jobs'),
		);

	public function get_mandatory() {
		return $this->_mandatory;
	}

	public function get_existing() {
		return $this->_existing;
	}

	public function get_format() {
		return $this->_format;
	}

	private function add_mandatory_parameter($parameter) {
		array_push($this->_mandatory, $parameter);
	}

	public function mandatory_parameters($given){
		foreach ($this->_mandatory as $field) {
			if (!array_key_exists($field, $given)) {
				return False;
			}
		}
		return True;

	}

	public function existing_parameters($given){
		foreach ($given as $field => $value) {
			if (!array_key_exists($field, this->_existing))
				return False;
		}
		return True;
	}

	public function valid_parameters($given){
		foreach ($given as $field => $value) {
			if (!in_array($value, $this->_format[$field])) {
				return False;
			}

			//Conditional paramaters according to t value (hit type)
			if ($field == 't') {
				if ($value == 'event') {
					add_mandatory_parameter('ec');
					add_mandatory_parameter('ea');
				}
				if ($value == 'screenview')
					add_mandatory_parameter('sn');
			}
		}
		return True;

	}

}
