<?php

class RemotedbConnection {

	protected $options;

	public function __construct() {
		$config = JFactory::getConfig();
		$this->options = [];
		$this->options['driver']   = $config->get('dbtype');
		$this->options['host']     = $config->get('remote_host');
		$this->options['user']     = $config->get('remote_user');
		$this->options['password'] = $config->get('remote_password');
		$this->options['database'] = $config->get('remote_db');
		$this->options['prefix']   = $config->get('remote_dbprefix');
	}

	public function connect() {
		if ($db_remote = JDatabase::getInstance($this->options)) {
			return $db_remote;
		} else {
			echo 'Could not connect to remote db';
			die;
		}
	}
}