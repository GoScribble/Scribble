<?php /*

use Scribble\Publisher;

class PublisherTest extends \PHPUnit_Framework_TestCase
{
    public function testAllDefinition()
    {
        $this->assertInstanceOf("\Scribble\PublisherService", Publisher::all());
    }
    
    public function testOnlyDefinition()
    {
        $this->assertInstanceOf("\Scribble\PublisherService", Publisher::only(["wpp"]));
    }
    
    public function testOnlyDefinitionWithInvalidNicknames()
    {
        $this->expectOutputString("Scribble Exception: There are no providers available for use, check your Scribble 'Config/config.php' file");
        Publisher::only(["wp", "SomeNonExistantNickname"]);
    }
}*/