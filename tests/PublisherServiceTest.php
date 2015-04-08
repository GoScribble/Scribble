<?php

use Scribble\PublisherService;

class PublisherServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testOnlyDefinition()
    {
        $service = new PublisherService();
        $this->assertInstanceOf("\Scribble\PublisherService", $service->only(["wpp"]));
    }
}