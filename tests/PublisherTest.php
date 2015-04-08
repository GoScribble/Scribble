<?php

use Scribble\Publisher;

class PublisherTest extends \PHPUnit_Framework_TestCase
{
    public function basicUseTest()
    {
        Publisher::any()->create([
            "post_title"    => "Hello Title",
            "post_content"  => "Hello World!"
            ]);
    }
}