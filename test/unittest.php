<?php

$error_count = 0;

define('BASE_DIR', getcwd() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
define('BANANA_DIR', BASE_DIR . 'banana' . DIRECTORY_SEPARATOR);
define('PUBLIC_DIR', getcwd() . DIRECTORY_SEPARATOR);
define('CONTROLLERS_PATH', PUBLIC_DIR . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR);
define('MODELS_PATH', PUBLIC_DIR . DIRECTORY_SEPARATOR . 'Models' . DIRECTORY_SEPARATOR);
define('VIEWS_PATH', PUBLIC_DIR . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR);

//error_reporting(E_ERROR | E_PARSE);

function createTest($instance, $disorder=true)
{
    if ($instance instanceof UnitTest)
    {
        echo PHP_EOL . 'Testing ' . get_class($instance) . PHP_EOL;
        foreach(get_class_methods($instance) as $method)
        {
            $pos = strpos($method, 'test');
            if ($pos !== false)
            {
                if ($pos == 0)
                {
                    try
                    {
                        $instance->setup();
                        $instance->$method();
                        $instance->teardown();
                        echo str_pad("\t$method \033[32m", 75) . "OK\033[37m" . PHP_EOL;
                    }
                    catch(Exception $e)
                    {
                        global $error_count;
                        $error_count++;
                        echo str_pad("\t$method \033[31m", 71) . "Failed\033[37m ( " . $e->getMessage() . ")" . PHP_EOL;
                    }
                }
            }
        }
    }
    else
    {
        die("The test object is not a child of UnitTest");
    }
}

class UnitTestError extends Exception {}

class UnitTest
{
    public function setup() {}
    public function teardown() {}
    
    private function getname($a) {
        if (is_object($a)) {
            $a = get_class($a);
        }
        return $a;
    }
    public function assertInstanceOf($a,$b) {
        if ($a instanceof $b) {
            return;
        }
        throw new UnitTestError(get_class($a) . ' is not an instance of ' . get_class($b));
    }
    
    public function assertNotInstanceOf($a, $b) {
        if (!($a instanceof $b)) {
            return;
        }
        throw new UnitTestError(get_class($a) . " is an instance of $b");
    }
    
    public function assertStrictlyEqual($a, $b) {
        if ($a === $b) {
            return;
        }

        $a = $this->getname($a);
        $b = $this->getname($b);
        
        throw new UnitTestError("'$a' isn't strictly equal (===) with '$b'");
    }
    
    public function assertEqual($a, $b) {
        if ($a == $b) {
            return;
        }

        $a = $this->getname($a);
        $b = $this->getname($b);
        
        throw new UnitTestError("'$a' isn't equal (==) with '$b'");
    }
    
    public function assertStringStartsWith($start, $str) {
        $start = preg_quote($start);
        if (preg_match("#^$start#", $str)) {
            return;
        }
        
        throw new UnitTestError("'$str' don't starts with '$start'");
    }
    
    public function assertStringContains($a, $b) {
        $a = preg_quote($a);
        if (preg_match("#$a#", $b)) {
            return;
        }
        
        throw new UnitTestError("'$a' don't contains '$b'");
    }
    
    public function assertTrue($a) {
        return $a == true;
    }
    
    public function assertStrictlyTrue($a) {
        return $a === true;
    }

    public function assertFalse($a) {
        return $a == false;
    }
    
    public function assertStrictlyFalse($a) {
        return $a === false;
    }
}
