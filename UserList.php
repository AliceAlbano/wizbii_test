<?php

class UserList
{
	private $_userlist = array("alice", "bob", "charles", "r2d2");

	public function get_userlist() {
		return $this->_userlist;
	}
}
