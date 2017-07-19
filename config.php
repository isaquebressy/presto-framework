<?php

/**
 * DB access configurations
 *
 *  PHP version 4
 *
 *  @category Utility
 *  @package  Utility
 *  @author   Isaque Bressy <isaquebressy@gmail.com>
 *  @license  https://www.gnu.org/licenses/gpl.html GNU
 *  @version  GIT: 0.0.1
 */
$config = array();

$config['default']['db_host'] = 'db';
$config['default']['db_name'] = 'presto';
$config['default']['db_user'] = 'presto';
$config['default']['db_pass'] = 'presto';

define('DB_HOST', $config['default']['db_host']);
define('DB_NAME', $config['default']['db_name']);
define('DB_USER', $config['default']['db_user']);
define('DB_PASS', $config['default']['db_pass']);
