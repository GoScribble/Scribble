<?php

use Scribble\PublisherService;

class PublisherServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testOnlyDefinition()
    {
        $service = new PublisherService();
        $this->assertNotFalse($service->only(["wp"]));
    }
    
    public function testAllDefinition()
    {
        $service = new PublisherService();
        $this->assertNotFalse($service->all());
    }
    
    public function testOnlyDefinitionWithInvalidNickname()
    {
        $service = new PublisherService();
        $this->assertFalse($service->only(["wp", "NicknameThatDoesntExist"]));
    }
}