<?php
/**
 * Created by PhpStorm.
 * User: Yuriy
 * Date: 26.01.2016
 * Time: 22:05
 */

// Set MySQL connection parameters here

define('DB_HOST', 'localhost');
define('DB_USER', 'netpeak');
define('DB_PASSWORD', 'netpeak');
define('DB_BASE', 'calendar');

define('DATE_PATTERN', "/^(20[0-2][0-9])-([0-1][0-9])-([0-3][0-9])$/");

define('SITE_ROOT', '/');
define('LOG_DIR', __DIR__ . '/log/');