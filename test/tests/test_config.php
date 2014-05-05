<?php

require_once 'conf/config.php';

class TestConfiguration extends UnitTest
{
    var $config;
    
    public function setup()
    {
        $this->config = \Banana\Conf\Config::getInstance();
    }
    
    public function testSingleton()
    {
        $c = \Banana\Conf\Config::getInstance();
        
        $this->assertStrictlyEqual($this->config, $c);
    }
    
    /* Test both __set and __get */
    public function testAddKey()
    {
        $akey = 'akey';
        $this->config->aKey = 'akey';
        $this->assertEqual($this->config->aKey, 'akey');
        $this->assertStrictlyEqual($this->config->aKey, $akey);
    }
    
    public function testAddPath()
    {
        $path = 'c:\\DummyTest';
        $this->config->addPath($path);
        $this->assertStringStartsWith($path, get_include_path());
    }
    
    public function testAddLibrary()
    {
        $library = 'testlib';
        $this->config->addLibrary($library);
        $this->assertStringStartsWith($this->getFullLibPath($library), get_include_path());
    }
    
    public function testAddLibraries()
    {
        $libraries = ['testlib1', 'testlib2'];
        $this->config->addLibraries($libraries);
        $this->assertStringContains($this->getFullLibPath($libraries[0]) , get_include_path());
        $this->assertStringStartsWith($this->getFullLibPath($libraries[1]), get_include_path());
    }
    
    public function testKeyIsSet()
    {
        $this->config->aKey = 'akey';
        $this->assertTrue(isset($this->config->aKey));
    }
    
    private function getFullLibPath($path) {
        return $this->config->libraryPath . $path . PATH_SEPARATOR;
    }
}

createTest(new TestConfiguration);