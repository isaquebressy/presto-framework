<?php

$config = array();


/**
 * Used to inform the location of database server
 *
 */
$config['default']['db_host'] = 'localhost';
$config['default']['db_name'] = '';
$config['default']['db_user'] = '';
$config['default']['db_pass'] = '';

define ('DB_HOST',  $config['default']['db_host']);
define ('DB_NAME', 	$config['default']['db_name']);
define ('DB_USER',  $config['default']['db_user']);
define ('DB_PASS',  $config['default']['db_pass']);