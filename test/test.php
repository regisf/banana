<?php

//set_include_path(get_include_path() . PATH_SEPARATOR . getcwd());
//die (get_include_path());

include_once 'unittest.php';

function start_test($name)
{
    echo "==================== Testing $name ====================\n";
}

function end_test($name)
{
    echo "===================== End of $name ====================\n";    
}

printf("Test program for Banana\n");

start_test('Configuration');
//include('test_config.php');
include_once 'tests/test_core.php';

end_test('Configuration');

