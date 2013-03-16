<?php

namespace AthosHun\FeedParser;

class XMLFeedType
{
    private $namespace_name;
    private $namespace_uri;
    private $title_xpath;
    private $url_xpath;
    private $item_xpath;
    private $item_id_xpath;
    private $item_title_xpath;
    private $item_url_xpath;
    private $item_timestamp_xpath;
    private $item_body_xpath;

    public function __construct()
    {
    }

    public function setTitleXPath($title_xpath)
    {
        $this->title_xpath = (string)$title_xpath;

        return $this;
    }

    public function getTitleXPath()
    {
        return $this->title_xpath;
    }

    public function setURLXPath($url_xpath)
    {
        $this->url_xpath = (string)$url_xpath;

        return $this;
    }

    public function getURLXPath()
    {
        return $this->url_xpath;
    }

    public function setItemXPath($item_xpath)
    {
        $this->item_xpath = (string)$item_xpath;

        return $this;
    }

    public function getItemXPath()
    {
        return $this->item_xpath;
    }

    public function setItemIdXPath($item_id_xpath)
    {
        $this->item_id_xpath = (string)$item_id_xpath;

        return $this;
    }

    public function getItemIdXPath()
    {
        return $this->item_id_xpath;
    }

    public function setItemTitleXPath($item_title_xpath)
    {
        $this->item_title_xpath = (string)$item_title_xpath;

        return $this;
    }

    public function getItemTitleXPath()
    {
        return $this->item_title_xpath;
    }

    public function setItemURLXPath($item_url_xpath)
    {
        $this->item_url_xpath = (string)$item_url_xpath;

        return $this;
    }

    public function getItemURLXPath()
    {
        return $this->item_url_xpath;
    }

    public function setItemTimestampXPath($item_timestamp_xpath)
    {
        $this->item_timestamp_xpath = (string)$item_timestamp_xpath;

        return $this;
    }

    public function getItemTimestampXPath()
    {
        return $this->item_timestamp_xpath;
    }

    public function setItemBodyXPath($item_body_xpath)
    {
        $this->item_body_xpath = (string)$item_body_xpath;

        return $this;
    }

    public function getItemBodyXPath()
    {
        return $this->item_body_xpath;
    }

    public function hasNamespace()
    {
        return $this->namespace_name !== null
               && $this->namespace_uri !== null;
    }

    public function setNamespace($namespace_name, $namespace_uri)
    {
        $this->namespace_name = (string)$namespace_name;
        $this->namespace_uri = (string)$namespace_uri;

        return $this;
    }

    public function getNamespaceName()
    {
        return $this->namespace_name;
    }

    public function getNamespaceUri()
    {
        return $this->namespace_uri;
    }
}
