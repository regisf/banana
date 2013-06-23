<?php

function createTest($instance, $disorder=true)
{
    if ($instance instanceof UnitTest)
    {
        echo 'Testing ' . get_class($instance);
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
                        echo "...OK\n";
                    }
                    catch(Exception $e)
                    {
                        
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

class UnitTest
{
    public function setup() {}
    public function teardown() {}
}
