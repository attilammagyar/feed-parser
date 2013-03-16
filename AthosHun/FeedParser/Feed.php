<?php

namespace AthosHun\FeedParser;

interface Feed
{
    public function getTitle();
    public function getURL();
    public function getItems();
}
