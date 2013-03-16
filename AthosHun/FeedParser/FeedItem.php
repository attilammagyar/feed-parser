<?php

namespace AthosHun\FeedParser;

class FeedItem
{
    private $id;
    private $title;
    private $url;
    private $timestamp;
    private $body;

    public function __construct($id, $title, $url, $timestamp, $body)
    {
        $this->id = (string)$id;
        $this->title = (string)$title;
        $this->url = (string)$url;
        $this->timestamp = (int)$timestamp;
        $this->body = (string)$body;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getURL()
    {
        return $this->url;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function getBody()
    {
        return $this->body;
    }
}
