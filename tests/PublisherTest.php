<?php

use Scribble\Publisher;

class PublisherTest extends \PHPUnit_Framework_TestCase
{
    public function testAllDefinition()
    {
        $this->assertInstanceOf("\Scribble\PublisherServicee", Publisher::all());
    }
}