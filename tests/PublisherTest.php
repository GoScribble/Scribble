<?php

use Scribble\Publisher;

class PublisherTest extends \PHPUnit_Framework_TestCase
{
    public function testAllDefinition()
    {
        $this->assertTrue(Publisher::all());
    }
}