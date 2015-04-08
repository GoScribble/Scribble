<?php

use Scribble\Publisher;

class PublisherTest extends \PHPUnit_Framework_TestCase
{
    public function testAllDefinition()
    {
        $this->assertInstanceOf("\Scribble\PublisherService", Publisher::all());
    }
    
    public function testOnlyDefinition()
    {
        $this->assertInstanceOf("\Scribble\PublisherService", Publisher::only(["wp"]));
    }
    
    public function testOnlyDefinitionWithInvalidNicknames()
    {
        $publisherReturn = Publisher::only(["wp", "SomeNonExistantNickname"]);
        $this->assertNotInstanceOf("\Scribble\PublisherService", $publisherReturn);
    }
}