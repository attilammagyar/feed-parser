<?php

namespace AthosHun\FeedParser;

class FeedItemTest extends \PHPUnit_Framework_TestCase
{
    public function testFeedItemIsADataStructure()
    {
        $id = "abcdef123";
        $title = "Hello";
        $url = "http://example.com";
        $timestamp = 1234567890;
        $body = "Hello World! Lorem ipsum dolor sit amet.";

        $feed_item = new FeedItem($id, $title, $url, $timestamp, $body);

        $this->assertSame($id, $feed_item->getId());
        $this->assertSame($title, $feed_item->getTitle());
        $this->assertSame($url, $feed_item->getURL());
        $this->assertSame($timestamp, $feed_item->getTimestamp());
        $this->assertSame($body, $feed_item->getBody());
    }
}
