<?php

namespace AthosHun\FeedParser;

class XMLFeed implements Feed
{
    private $type;
    private $dom_document;
    private $xpath;

    public function __construct(XMLFeedType $type, \DOMDocument $xml_feed_dom)
    {
        $this->type = $type;
        $this->dom_document = $xml_feed_dom;
        $this->xpath = $this->makeXPath();
    }

    private function makeXPath()
    {
        $xpath = new \DOMXPath($this->dom_document);

        if ($this->type->hasNamespace())
        {
            $namespace_name = $this->type->getNamespaceName();
            $namespace_uri = $this->type->getNamespaceUri();
            $xpath->registerNamespace($namespace_name, $namespace_uri);
        }

        return $xpath;
    }

    public function getTitle()
    {
        return $this->fetchString(
            $this->type->getTitleXPath(),
            $this->dom_document
        );
    }

    private function fetchString($xpath_query, \DOMNode $context_node)
    {
        $result = $this->xpath->evaluate($xpath_query, $context_node);

        if (is_object($result) && ($result instanceof \DOMNodeList)) {
            return $this->fetchStringFromDOMNodeList($result);
        } else {
            return (string)$result;
        }
    }

    private function fetchStringFromDOMNodeList(\DOMNodeList $list)
    {
        if ($list->length == 0) {
            return "";
        }

        return $list->item(0)->nodeValue;
    }

    public function getURL()
    {
        return $this->fetchString(
            $this->type->getURLXPath(),
            $this->dom_document
        );
    }

    public function getItems()
    {
        $feed_items = array();
        $root_xpath = $this->type->getItemXPath();
        $feed_item_nodes = $this->xpath->evaluate($root_xpath);

        for ($i = 0; $i != $feed_item_nodes->length; ++$i) {
            $feed_item_node = $feed_item_nodes->item($i);
            $feed_items[] = $this->parseFeedItem($feed_item_node);
        }

        return $feed_items;
    }

    private function parseFeedItem(\DOMNode $feed_item_node)
    {
        $id = $this->parseFeedItemId($feed_item_node);
        $title = $this->parseFeedItemTitle($feed_item_node);
        $url = $this->parseFeedItemURL($feed_item_node);
        $timestamp = $this->parseFeedItemTimestamp($feed_item_node);
        $body = $this->parseFeedItemBody($feed_item_node);

        return new FeedItem($id, $title, $url, $timestamp, $body);
    }

    private function parseFeedItemId(\DOMNode $feed_item_node)
    {
        $id_xpath = $this->type->getItemIdXPath();

        return $this->fetchString($id_xpath, $feed_item_node);
    }

    private function parseFeedItemTitle(\DOMNode $feed_item_node)
    {
        $title_xpath = $this->type->getItemTitleXPath();

        return $this->fetchString($title_xpath, $feed_item_node);
    }

    private function parseFeedItemURL(\DOMNode $feed_item_node)
    {
        $url_xpath = $this->type->getItemURLXPath();

        return $this->fetchString($url_xpath, $feed_item_node);
    }

    private function parseFeedItemTimestamp(\DOMNode $feed_item_node)
    {
        $timestamp_xpath = $this->type->getItemTimestampXPath();

        return $this->fetchTimestamp($timestamp_xpath, $feed_item_node);
    }

    private function fetchTimestamp($xpath_query, \DOMNode $context_node)
    {
        $datetime_string = $this->fetchString($xpath_query, $context_node);
        $datetime = new \DateTime($datetime_string);

        return $datetime->getTimestamp();
    }

    private function parseFeedItemBody(\DOMNode $feed_item_node)
    {
        $body_xpath = $this->type->getItemBodyXPath();

        return $this->fetchString($body_xpath, $feed_item_node);
    }
}
