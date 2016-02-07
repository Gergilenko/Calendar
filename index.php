<?php

error_reporting(E_ALL);

require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/config.php';


$ctrl = isset($_GET['ctrl']) ? ucfirst($_GET['ctrl']) : 'Calendar';
$act = isset($_GET['act']) ? ucfirst($_GET['act']) : 'Index';


$ctrlClassName = 'app\\controllers\\' . $ctrl . 'Controller';
$method = 'action' . $act;

$controller = new $ctrlClassName;
//Start application
$controller->$method();