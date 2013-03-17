FeedParser
==========

A simple library to parse the most important information from RSS and Atom
feeds.

Example:

```php
<?php

function print_rss($rss_xml)
{
    $dom = new DOMDocument("1.0", "UTF-8");
    $dom->loadXML($rss_xml);

    $rss = new AthosHun\FeedParser\RSSFeedType();
    $xml_feed = new AthosHun\FeedParser\XMLFeed($rss, $dom);

    print "Title: " . $xml_feed->getTitle() . "\n";
    print "URL: " . $xml_feed->getURL() . "\n\n";

    foreach ($xml_feed->getItems() as $key => $item) {
        $i = $key + 1;
        print " $i. Id: " . $item->getId() . "\n";
        print " $i. Title: " . $item->getTitle() . "\n";
        print " $i. URL: " . $item->getURL() . "\n";
        print " $i. Timestamp: "
              . date("Y-m-d H:i:s", $item->getTimestamp()) . "\n";
        print " $i. Body: " . $item->getBody() . "\n\n";
    }
}

print_rss(<<<RSS
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
  <channel>
    <title>Foo</title>
    <link>http://www.example.com/</link>
    <pubDate>Mon, 18 Mar 2013 08:43:35 GMT</pubDate>
    <description>Lorem ipsum dolor sit amet</description>
    <item>
      <title>First item</title>
      <link>http://www.example.com/first</link>
      <description>The quick brown fox</description>
      <pubDate>Mon, 18 Mar 2013 08:43:35 GMT</pubDate>
      <guid>http://www.example.com/first</guid>
    </item>
    <item>
      <title>Second item</title>
      <link>http://www.example.com/second</link>
      <description>Jumps over the lazy dog</description>
      <pubDate>Mon, 18 Mar 2013 08:42:12 GMT</pubDate>
      <guid>http://www.example.com/second</guid>
    </item>
  </channel>
</rss>
RSS
);

```

The above script will output:

    Title: Foo
    URL: http://www.example.com/
    
     1. Id: http://www.example.com/first
     1. Title: First item
     1. URL: http://www.example.com/first
     1. Timestamp: 2013-03-18 09:43:35
     1. Body: The quick brown fox
    
     2. Id: http://www.example.com/second
     2. Title: Second item
     2. URL: http://www.example.com/second
     2. Timestamp: 2013-03-18 09:42:12
     2. Body: Jumps over the lazy dog

Installation
------------

Installation is possible via [Composer][composer]. Create a file named
`composer.json` in your project directory with the following contents:

  [composer]: http://getcomposer.org/

    {
        "require": {
            "athoshun/feed-parser": "1.0.*"
        }
    }

Then as a normal user, issue the following commands:

    $ curl http://getcomposer.org/installer | php
    $ php composer.phar install
