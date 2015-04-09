<?php

use Scribble\PublisherService;

class PublisherServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testAllDefinition()
    {
        $service = new PublisherService();
        $this->assertNotFalse($service->all());
    }
    
    public function testOnlyDefinition()
    {
        $service = new PublisherService();
        $this->assertNotFalse($service->only(["wp"]));
    }
    
    public function testOnlyDefinitionWithInvalidNickname()
    {
        $service = new PublisherService();
        $this->assertFalse($service->only(["wp", "NicknameThatDoesntExist"]));
    }
    
    public function testGroupDefinition()
    {
        $service = new PublisherService();
        $this->assertNotFalse($service->group(["ExGroup"]));
    }
    
    public function testGroupDefinitionWithInvalidGroup()
    {
        $service = new PublisherService();
        $this->assertFalse($service->group(["ExGroup", "GroupThatDoesntExist"]));
    }
}