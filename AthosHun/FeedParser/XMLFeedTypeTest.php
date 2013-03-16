<?php

namespace AthosHun\FeedParser;

class XMLFeedTypeTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->xml_feed_type = new XMLFeedType();
    }

    public function testXmlFeedTypeIsADataStructure()
    {
        $title_xpath = "/feed/title/text()";
        $url_xpath = "/feed/link/@href";
        $item_xpath = "/feed/items/item";
        $item_id_xpath = "id/text()";
        $item_title_xpath = "title/text()";
        $item_url_xpath = "url/@href";
        $item_timestamp_xpath = "timestamp/text()";
        $item_body_xpath = "body/text()";

        $this->xml_feed_type->setTitleXPath($title_xpath)
                            ->setURLXPath($url_xpath)
                            ->setItemXPath($item_xpath)
                            ->setItemIdXPath($item_id_xpath)
                            ->setItemTitleXPath($item_title_xpath)
                            ->setItemURLXPath($item_url_xpath)
                            ->setItemTimestampXPath($item_timestamp_xpath)
                            ->setItemBodyXPath($item_body_xpath);

        $this->assertSame($title_xpath, $this->xml_feed_type->getTitleXPath());
        $this->assertSame($url_xpath, $this->xml_feed_type->getURLXPath());
        $this->assertSame($item_xpath, $this->xml_feed_type->getItemXPath());
        $this->assertSame(
            $item_id_xpath,
            $this->xml_feed_type->getItemIdXPath()
        );
        $this->assertSame(
            $item_title_xpath,
            $this->xml_feed_type->getItemTitleXPath()
        );
        $this->assertSame(
            $item_url_xpath,
            $this->xml_feed_type->getItemURLXPath()
        );
        $this->assertSame(
            $item_timestamp_xpath,
            $this->xml_feed_type->getItemTimestampXPath()
        );
        $this->assertSame(
            $item_body_xpath,
            $this->xml_feed_type->getItemBodyXPath()
        );
    }

    public function testXmlFeedTypeCanHaveXmlNamespace()
    {
        $this->assertFalse($this->xml_feed_type->hasNamespace());

        $namespace_name = "foo";
        $namespace_uri = "http://foo.bar";
        $this->xml_feed_type->setNamespace(
            $namespace_name,
            $namespace_uri
        );

        $this->assertTrue($this->xml_feed_type->hasNamespace());
        $this->assertSame(
            $namespace_name,
            $this->xml_feed_type->getNamespaceName()
        );
        $this->assertSame(
            $namespace_uri,
            $this->xml_feed_type->getNamespaceUri()
        );
    }
}
