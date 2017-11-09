<?php

$options['driver']   = $config->get('dbtype');
$options['host']     = $config->get('remote_host');
$options['user']     = $config->get('remote_user');
$options['password'] = $config->get('remote_password');
$options['database'] = $config->get('remote_db');
$options['prefix']   = $config->get('remote_dbprefix');

$db_remote = JDatabase::getInstance( $options) ;

//global $db_remote;

?>