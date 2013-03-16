<?php

namespace AthosHun\FeedParser;

class AtomFeedType extends XMLFeedType
{
    public function __construct()
    {
        parent::__construct();
        $this->setNamespace("f", "http://www.w3.org/2005/Atom")
             ->setTitleXPath("/f:feed/f:title/text()")
             ->setURLXPath(
                "/f:feed/f:link[(@rel='alternate' or count(@rel)=0)"
                . " and (@type='text/html' or count(@type)=0)]/@href"
             )
             ->setItemXPath("/f:feed/f:entry")
             ->setItemIdXPath("f:id/text()")
             ->setItemTitleXPath("f:title/text()")
             ->setItemURLXPath("f:link[@rel='alternate']/@href")
             ->setItemTimestampXPath("f:published/text()")
             ->setItemBodyXPath("f:content[@type='html']/text()");
    }
}
