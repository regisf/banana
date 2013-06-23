<?php

/**
 * Test basic function
 */
require_once('banana/Utils/with_statment.php');

class TestWithStatement extends UnitTest
{
    public function testWith()
    {
        with(new Test )
    }
}

createTest(new TestWithStatement());
