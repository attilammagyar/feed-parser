<?php

namespace AthosHun\FeedParser;

class RSSFeedType extends XMLFeedType
{
    public function __construct()
    {
        parent::__construct();
        $this->setTitleXPath("/rss/channel/title/text()")
             ->setURLXPath("/rss/channel/link/text()")
             ->setItemXPath("/rss/channel/item")
             ->setItemIdXPath("guid/text()")
             ->setItemTitleXPath("title/text()")
             ->setItemURLXPath("link/text()")
             ->setItemTimestampXPath("pubDate/text()")
             ->setItemBodyXPath("description/text()");
    }
}
