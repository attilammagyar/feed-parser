<?php

namespace AthosHun\FeedParser;

class XMLFeedTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideXMLFeedScenarios
     */
    public function testMetaDataAndItemsAreParsedFromXMLFeed(
        $expected_title,
        $expected_url,
        array $expected_items,
        XMLFeedType $type,
        $xml_feed_body
    ) {
        $xml_feed = $this->makeXMLFeed($type, $xml_feed_body);

        $this->assertSame($expected_title, $xml_feed->getTitle());
        $this->assertSame($expected_url, $xml_feed->getURL());
        $this->assertEquals($expected_items, $xml_feed->getItems());
    }

    private function makeXMLFeed(XMLFeedType $type, $xml_feed_body)
    {
        return new XMLFeed($type, $this->makeDOMDocument($xml_feed_body));
    }

    private function makeDOMDocument($xml_body)
    {
        $xml_header = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
        $dom_document = new \DOMDocument("1.0", "UTF-8");
        $dom_document->loadXML($xml_header . $xml_body);

        return $dom_document;
    }

    public function provideXMLFeedScenarios()
    {
        $atom_type = new AtomFeedType();
        $rss_type = new RSSFeedType();

        list(
            $expected_title,
            $expected_url,
            $expected_items,
            $rss_body,
            $atom_body
        ) = $this->makeComplexScenario();

        $empty_atom_xml = "<feed xmlns=\"http://www.w3.org/2005/Atom\"/>";

        return array(
            "Empty RSS" => array("", "", array(), $rss_type, "<rss/>"),
            "Empty Atom" => array("", "", array(), $atom_type, $empty_atom_xml),
            "Complex RSS" => array(
                $expected_title,
                $expected_url,
                $expected_items,
                $rss_type,
                $rss_body
            ),
            "Complex Atom" => array(
                $expected_title,
                $expected_url,
                $expected_items,
                $atom_type,
                $atom_body
            ),
        );
    }

    private function makeComplexScenario()
    {
        $item_id1 = "abcdef123";
        $item_title1 = "First Title";
        $item_url1 = "http://first.url";
        $item_raw_timestamp1 = "Mon, 18 Jun 2012 01:01:01 +0000";
        $item_timestamp1 = 1339981261;
        $item_body1 = "First lorem ipsum dolor sit amet";

        $item_id2 = "http://second.url/hello?world=foo";
        $item_title2 = "Second Title";
        $item_url2 = "http://second.url/hello?world=foo";
        $item_raw_timestamp2 = "Mon, 18 Jun 2012 02:02:02 +0000";
        $item_timestamp2 = 1339984922;
        $item_body2 = "Second consectetur adipiscing elit";

        $expected_feed_title = "Feed title";
        $expected_feed_url = "http://example.com/feed";

        $expected_feed_items = array(
            new FeedItem(
                $item_id1,
                $item_title1,
                $item_url1,
                $item_timestamp1,
                $item_body1
            ),
            new FeedItem(
                $item_id2,
                $item_title2,
                $item_url2,
                $item_timestamp2,
                $item_body2
            )
        );

        $rss_feed_body = <<<RSS
<rss>
    <channel>
        <title>$expected_feed_title</title>
        <link>$expected_feed_url</link>
        <item>
            <guid>$item_id1</guid>
            <title>$item_title1</title>
            <link>$item_url1</link>
            <pubDate>$item_raw_timestamp1</pubDate>
            <description>$item_body1</description>
        </item>
        <item>
            <guid>$item_id2</guid>
            <title>$item_title2</title>
            <link>$item_url2</link>
            <pubDate>$item_raw_timestamp2</pubDate>
            <description><![CDATA[$item_body2]]></description>
        </item>
    </channel>
</rss>
RSS;

        $atom_feed_body = <<<Atom
<feed xmlns="http://www.w3.org/2005/Atom">
    <title>$expected_feed_title</title>
    <link href="$expected_feed_url" />
    <entry>
        <id>$item_id1</id>
        <title>$item_title1</title>
        <link rel="alternate" type="text/html" href="$item_url1"/>
        <published>$item_raw_timestamp1</published>
        <content type="html">$item_body1</content>
    </entry>
    <entry>
        <id>$item_id2</id>
        <title>$item_title2</title>
        <link rel="alternate" type="text/html" href="$item_url2"/>
        <published>$item_raw_timestamp2</published>
        <content type="html"><![CDATA[$item_body2]]></content>
    </entry>
</feed>
Atom;

        return array(
            $expected_feed_title,
            $expected_feed_url,
            $expected_feed_items,
            $rss_feed_body,
            $atom_feed_body,
        );
    }

    /**
     * @dataProvider provideAtomFeedsWithLinks
     */
    public function testAtomFeedsMayContainVariousLinksFlavors($preferred_link)
    {
        $atom_xml =  "<feed xmlns=\"http://www.w3.org/2005/Atom\">"
                     . "<link rel=\"self\" href=\"http://self/atom\"/>"
                     . "$preferred_link</feed>";
        $xml_feed = $this->makeXMLFeed(new AtomFeedType(), $atom_xml);

        $this->assertSame("http://expected/link", $xml_feed->getURL());
    }

    public function provideAtomFeedsWithLinks()
    {
        $url = "http://expected/link";
        return array(
            "Alternate text/html link is preferred over self link" => array(
                "<link rel=\"alternate\" type=\"text/html\" href=\"$url\"/>"
            ),
            "text/html link is preferred over self link" => array(
                "<link type=\"text/html\" href=\"$url\"/>"
            ),
            "Alternate link is preferred over self link" => array(
                "<link type=\"text/html\" href=\"$url\"/>"
            ),
            "Link without attributes is preferred over self link" => array(
                "<link href=\"$url\"/>"
            ),
        );
    }
}
