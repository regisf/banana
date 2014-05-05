<?php

//include_once 'unittest.php';
//
//echo 'Test program for Banana' . PHP_EOL;
//
//include_once 'tests/test_with.php';
//include_once 'tests/test_config.php';
//
//global $error_count;
//echo PHP_EOL . "Number of errors: $error_count" . PHP_EOL;

set_include_path(realpath(dirname(__FILE__) . '../../') . PATH_SEPARATOR . get_include_path());
require_once 'tests' . DIRECTORY_SEPARATOR . 'test_with.php';
